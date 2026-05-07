<?php

namespace Database\Seeders;

use App\Models\Career;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $careers = [
            [
                'title'        => 'Sales Consultant Properti',
                'department'   => 'Sales & Marketing',
                'location'     => 'Jakarta Selatan',
                'type'         => 'full-time',
                'description'  => "Kami mencari Sales Consultant yang bersemangat untuk bergabung dengan tim penjualan properti Midland.\n\nTanggung Jawab:\n• Melayani dan membantu calon pembeli dalam proses pencarian properti\n• Melakukan presentasi produk kepada klien potensial\n• Membangun dan menjaga hubungan baik dengan klien\n• Mencapai target penjualan bulanan\n• Mengikuti perkembangan pasar properti secara aktif",
                'requirements' => "• Pendidikan minimal D3/S1 semua jurusan\n• Pengalaman di bidang sales min. 1 tahun (pengalaman properti lebih diutamakan)\n• Komunikatif, persuasif, dan berorientasi target\n• Memiliki kendaraan pribadi dan SIM C/A\n• Bersedia bekerja di hari Sabtu",
                'deadline'     => Carbon::now()->addMonths(2)->toDateString(),
                'is_active'    => true,
                'sort_order'   => 1,
            ],
            [
                'title'        => 'Digital Marketing Specialist',
                'department'   => 'Marketing',
                'location'     => 'Jakarta Pusat (WFH Hybrid)',
                'type'         => 'full-time',
                'description'  => "Bergabunglah sebagai Digital Marketing Specialist dan bantu Midland Properti memperluas jangkauan digital.\n\nTanggung Jawab:\n• Merancang dan menjalankan kampanye iklan digital (Meta Ads, Google Ads, TikTok Ads)\n• Mengelola konten media sosial Instagram, Facebook, TikTok, YouTube\n• Menganalisis performa kampanye dan membuat laporan rutin\n• Berkolaborasi dengan tim desain untuk pembuatan konten kreatif\n• Optimasi SEO website perusahaan",
                'requirements' => "• Pendidikan S1 Marketing, Komunikasi, atau bidang terkait\n• Pengalaman min. 2 tahun di digital marketing\n• Familiar dengan Meta Ads Manager, Google Ads, dan analitik\n• Kemampuan copywriting yang baik dalam Bahasa Indonesia\n• Kreatif, data-driven, dan up-to-date dengan tren digital",
                'deadline'     => Carbon::now()->addMonths(1)->toDateString(),
                'is_active'    => true,
                'sort_order'   => 2,
            ],
            [
                'title'        => 'Admin & Customer Service',
                'department'   => 'Operations',
                'location'     => 'Jakarta Selatan',
                'type'         => 'full-time',
                'description'  => "Kami membutuhkan Admin & Customer Service yang ramah dan teliti untuk mendukung operasional kantor.\n\nTanggung Jawab:\n• Melayani pertanyaan klien via telepon, email, dan WhatsApp\n• Membantu administrasi dokumen jual-beli dan KPR\n• Menginput dan memperbarui data properti di sistem\n• Koordinasi jadwal pertemuan antara klien dan agen\n• Mengelola arsip dan dokumen kantor",
                'requirements' => "• Pendidikan min. D3 semua jurusan\n• Pengalaman sebagai admin/CS min. 1 tahun\n• Mahir Microsoft Office (Word, Excel)\n• Komunikasi yang baik dan sopan\n• Detail-oriented dan mampu multitasking",
                'deadline'     => Carbon::now()->addMonths(3)->toDateString(),
                'is_active'    => true,
                'sort_order'   => 3,
            ],
            [
                'title'        => 'Junior Web Developer (Magang)',
                'department'   => 'IT & Technology',
                'location'     => 'Remote / Jakarta',
                'type'         => 'internship',
                'description'  => "Kesempatan magang menarik bagi mahasiswa atau fresh graduate yang ingin mendapatkan pengalaman nyata di lingkungan profesional.\n\nTanggung Jawab:\n• Membantu pengembangan dan pemeliharaan website perusahaan\n• Implementasi fitur-fitur baru berdasarkan kebutuhan bisnis\n• Testing dan debugging aplikasi\n• Dokumentasi teknis",
                'requirements' => "• Mahasiswa aktif atau fresh graduate Teknik Informatika/Sistem Informasi\n• Menguasai HTML, CSS, JavaScript dasar\n• Nilai tambah: pengalaman dengan Laravel/PHP atau React/Vue\n• Bersedia magang selama min. 3 bulan\n• Proaktif dan mau belajar",
                'deadline'     => Carbon::now()->addWeeks(6)->toDateString(),
                'is_active'    => true,
                'sort_order'   => 4,
            ],
        ];

        foreach ($careers as $data) {
            Career::firstOrCreate(['title' => $data['title']], $data);
        }
    }
}
