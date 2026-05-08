<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatService
{
    private const API_URL    = 'https://open.bigmodel.cn/api/paas/v4/chat/completions';
    private const MODEL      = 'glm-4-flash'; // Free on bigmodel.cn
    private const MAX_HISTORY   = 20; // Keep last 20 messages for context

    public function __construct(private string $sessionId) {}

    /**
     * Zhipu AI keys are formatted as "{id}.{secret}" and require a JWT token.
     * We generate it inline without any extra library (pure HS256).
     */
    private function zhipuToken(): string
    {
        $apiKey = config('services.glm.key');
        [$id, $secret] = explode('.', $apiKey, 2);

        $b64 = fn(string $d) => rtrim(strtr(base64_encode($d), '+/', '-_'), '=');

        $header  = $b64(json_encode(['alg' => 'HS256', 'typ' => 'JWT', 'sign_type' => 'SIGN']));
        $payload = $b64(json_encode([
            'api_key'   => $id,
            'exp'       => (time() + 3600) * 1000,
            'timestamp' => (int) (microtime(true) * 1000),
        ]));
        $sig = $b64(hash_hmac('sha256', "$header.$payload", $secret, true));

        return "$header.$payload.$sig";
    }

    public function send(string $userMessage): string
    {
        // Persist user message
        ChatMessage::create([
            'session_id' => $this->sessionId,
            'role'       => 'user',
            'content'    => $userMessage,
        ]);

        $messages = $this->buildMessages();

        try {
            $response = Http::timeout(30)
                ->withToken($this->zhipuToken())
                ->post(self::API_URL, [
                    'model'       => self::MODEL,
                    'messages'    => $messages,
                    'temperature' => 0.7,
                    'max_tokens'  => 1024,
                ]);

            if ($response->failed()) {
                Log::error('Groq API error', ['status' => $response->status(), 'body' => $response->body()]);
                return 'Maaf, asisten sedang tidak tersedia. Silakan hubungi kami melalui WhatsApp atau telepon langsung.';
            }

            $reply = $response->json('choices.0.message.content', '');

            // Persist assistant message
            ChatMessage::create([
                'session_id' => $this->sessionId,
                'role'       => 'assistant',
                'content'    => $reply,
            ]);

            return $reply;

        } catch (\Throwable $e) {
            Log::error('Groq exception: ' . $e->getMessage());
            return 'Terjadi kesalahan sementara. Silakan coba lagi atau hubungi kami langsung.';
        }
    }

    public function history(): \Illuminate\Database\Eloquent\Collection
    {
        return ChatMessage::where('session_id', $this->sessionId)
            ->orderBy('created_at')
            ->get();
    }

    // ─── Private helpers ──────────────────────────────────────────────────

    private function buildMessages(): array
    {
        $history = ChatMessage::where('session_id', $this->sessionId)
            ->orderByDesc('created_at')
            ->take(self::MAX_HISTORY)
            ->get()
            ->reverse()
            ->values();

        $messages = [['role' => 'system', 'content' => $this->systemPrompt()]];

        foreach ($history as $msg) {
            $messages[] = ['role' => $msg->role, 'content' => $msg->content];
        }

        return $messages;
    }

    private function systemPrompt(): string
    {
        $siteName = Setting::get('site_name', 'Midland Properti');
        $address  = Setting::get('contact_address', 'Jl. Sudirman No. 88, Jakarta Pusat');
        $phone    = Setting::get('contact_phone', '+62 21-1234-5678');
        $email    = Setting::get('contact_email', 'info@midlandproperti.com');
        $wa       = Setting::get('social_whatsapp', '6281234567890');

        // Load live project catalog (up to 15)
        $projectLines = Project::orderBy('sort_order')
            ->take(15)
            ->get()
            ->map(fn($p) => "  - {$p->title} | {$p->type} | {$p->price} | {$p->location}" .
                            ($p->status !== 'available' ? " [{$p->status}]" : ''))
            ->implode("\n");

        return <<<PROMPT
Kamu adalah asisten properti virtual dari {$siteName}, bernama "Mida". Kamu ramah, profesional, dan hanya berbicara dalam Bahasa Indonesia.

INFORMASI PERUSAHAAN:
- Nama: {$siteName}
- Alamat: {$address}
- Telepon: {$phone}
- Email: {$email}
- WhatsApp: +{$wa}
- Pengalaman: Lebih dari 15 tahun melayani kebutuhan properti Indonesia

KATALOG PROPERTI TERSEDIA:
{$projectLines}

TUGAS UTAMA:
1. Bantu pengguna menemukan properti sesuai kebutuhan & anggaran mereka
2. Jelaskan detail proyek, tipe, harga, dan lokasi secara informatif
3. Tawarkan perhitungan estimasi cicilan KPR jika ditanya harga/cicilan
4. Arahkan ke halaman simulasi cicilan (/simulasi-cicilan) jika pengguna ingin hitung KPR
5. Arahkan ke halaman proyek (/project) untuk lihat semua listing
6. Jika pengguna serius membeli, minta mereka hubungi via WhatsApp: +{$wa}

PANDUAN RESPONS:
- Ringkas dan padat (maks 3 paragraf atau 5 poin)
- Gunakan emoji secukupnya untuk keramahan
- Jangan pernah membuat janji harga atau ketersediaan yang tidak ada di data
- Jika tidak tahu jawaban, arahkan ke tim langsung via WhatsApp
- Jangan keluar dari topik properti, investasi, dan layanan perusahaan
PROMPT;
    }
}
