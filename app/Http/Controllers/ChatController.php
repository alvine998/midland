<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /** Dedicated /chat page */
    public function index()
    {
        return view('front.chat', array_merge(
            [
                'site_name'        => Setting::get('site_name', 'Midland Properti'),
                'title'            => 'Chat Asisten Properti - ' . Setting::get('site_name', 'Midland Properti'),
                'meta_description' => 'Tanya asisten AI kami tentang properti impian Anda. Dapatkan rekomendasi dan informasi lengkap secara instan, 24 jam sehari.',
            ],
            $this->navData()
        ));
    }

    /** POST /api/chat/send — returns JSON */
    public function send(Request $request)
    {
        $request->validate([
            'message'    => ['required', 'string', 'max:1000'],
            'session_id' => ['required', 'string', 'max:128'],
        ]);

        $service = new ChatService($request->session_id);
        $reply   = $service->send(trim($request->message));

        return response()->json(['reply' => $reply]);
    }

    /** GET /api/chat/history — returns JSON */
    public function history(Request $request)
    {
        $request->validate([
            'session_id' => ['required', 'string', 'max:128'],
        ]);

        $service  = new ChatService($request->session_id);
        $messages = $service->history()->map(fn($m) => [
            'role'    => $m->role,
            'content' => $m->content,
            'time'    => $m->created_at->diffForHumans(),
        ]);

        return response()->json(['messages' => $messages]);
    }

    // ─── Private ─────────────────────────────────────────────────────────

    private function navData(): array
    {
        return [
            'menu_home'    => Setting::get('menu_home', 'Beranda'),
            'menu_project' => Setting::get('menu_project', 'Proyek'),
            'menu_gallery' => Setting::get('menu_gallery', 'Galeri'),
            'menu_about'   => Setting::get('menu_about', 'Tentang Kami'),
            'menu_contact' => Setting::get('menu_contact', 'Kontak'),
            'site_tagline' => Setting::get('site_tagline', 'Mitra Properti Terpercaya Anda'),
        ];
    }
}
