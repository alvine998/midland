<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Project;
use App\Models\Property;
use App\Models\Article;
use App\Models\Setting;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Testimonial;
use App\Models\Career;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@midlandproperti.com'],
            [
                'name'     => 'Admin Midland',
                'password' => Hash::make('admin123456'),
            ]
        );

        // Default settings
        $settings = [
            'site_name'       => 'Midland Properti',
            'site_tagline'    => 'Agen Properti Terpercaya Pilihan Indonesia',
            'menu_home'       => 'Beranda',
            'menu_project'    => 'Proyek',
            'menu_gallery'    => 'Galeri',
            'menu_about'      => 'Tentang Kami',
            'menu_contact'    => 'Kontak',
            'contact_email'   => 'info@midlandproperti.com',
            'contact_phone'   => '+62 21-1234-5678',
            'contact_address' => 'Jl. Sudirman No. 88, Jakarta Pusat 10220',
            'social_whatsapp' => '6281234567890',
            'social_instagram'=> 'https://instagram.com/midlandproperti',
            'social_facebook' => 'https://facebook.com/midlandproperti',
        ];
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Default pages
        $pages = [
            [
                'slug'         => 'home',
                'hero_title'   => 'Temukan Properti',
                'hero_subtitle'=> 'Impian Anda',
                'video_url'    => 'https://videos.pexels.com/video-files/3571211/3571211-hd_1920_1080_30fps.mp4',
                'section_title'=> 'Selamat Datang di Midland Properti',
                'content'      => 'Midland Properti hadir dengan ratusan pilihan properti terbaik — rumah, apartemen, komersial, dan tanah di lokasi strategis. Percayakan kebutuhan properti Anda kepada kami.',
            ],
            [
                'slug'         => 'project',
                'hero_title'   => 'Proyek Unggulan Kami',
                'hero_subtitle'=> 'Berbagai pilihan properti berkualitas di lokasi terbaik',
                'content'      => 'Temukan berbagai proyek properti pilihan yang telah kami kembangkan.',
            ],
            [
                'slug'         => 'gallery',
                'hero_title'   => 'Galeri Properti',
                'hero_subtitle'=> 'Lihat foto-foto proyek terbaik kami',
                'content'      => '',
            ],
            [
                'slug'         => 'about',
                'hero_title'   => 'Tentang Midland Properti',
                'hero_subtitle'=> 'Agen properti terpercaya pilihan keluarga Indonesia',
                'section_title'=> 'Siapa Kami?',
                'content'      => 'Midland Properti adalah agen properti terpercaya yang telah melayani kebutuhan properti Indonesia selama lebih dari 15 tahun. Kami berkomitmen memberikan pelayanan terbaik dalam membantu Anda menemukan properti impian dengan lokasi strategis dan harga terbaik.',
            ],
            [
                'slug'         => 'contact',
                'hero_title'   => 'Hubungi Kami',
                'hero_subtitle'=> 'Kami siap membantu Anda',
                'content'      => 'Jangan ragu untuk menghubungi kami. Tim profesional kami siap membantu Anda menemukan properti terbaik sesuai kebutuhan dan anggaran Anda.',
            ],
        ];
        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }

        // Sample projects
        $projects = [
            ['title' => 'Green Valley Residence', 'location' => 'Depok, Jawa Barat',    'price' => 'Rp 850 Juta',  'type' => 'rumah',     'status' => 'available', 'featured' => true,  'sort_order' => 1, 'description' => 'Hunian nyaman di kawasan hijau Depok dengan desain modern dan fasilitas lengkap. Dilengkapi taman bermain, kolam renang, dan area olahraga.', 'pic_name' => 'Budi Santoso', 'pic_phone' => '628123456789'],
            ['title' => 'Midland Apartemen Kuningan', 'location' => 'Kuningan, Jakarta', 'price' => 'Rp 600 Juta',  'type' => 'apartemen', 'status' => 'available', 'featured' => true,  'sort_order' => 2, 'description' => 'Apartemen premium di jantung kawasan bisnis Kuningan. Akses mudah ke berbagai pusat perkantoran dan hiburan.', 'pic_name' => 'Siti Nurhaliza', 'pic_phone' => '628234567890'],
            ['title' => 'Sentra Bisnis Pluit',      'location' => 'Pluit, Jakarta Utara','price' => 'Rp 2,5 Miliar','type' => 'komersial', 'status' => 'available', 'featured' => true,  'sort_order' => 3, 'description' => 'Ruko strategis di kawasan bisnis Pluit. Cocok untuk berbagai jenis usaha dengan lalu lintas tinggi.', 'pic_name' => 'Ahmad Wijaya', 'pic_phone' => '628345678901'],
            ['title' => 'Kavling Sentul City',      'location' => 'Sentul, Bogor',       'price' => 'Rp 450 Juta',  'type' => 'tanah',     'status' => 'available', 'featured' => false, 'sort_order' => 4, 'description' => 'Kavling siap bangun di kawasan Sentul City dengan udara segar dan panorama pegunungan.', 'pic_name' => 'Dewi Lestari', 'pic_phone' => '628456789012'],
            ['title' => 'The Midland Tower',        'location' => 'SCBD, Jakarta',       'price' => 'Rp 5 Miliar',  'type' => 'komersial', 'status' => 'upcoming',  'featured' => true,  'sort_order' => 5, 'description' => 'Proyek office tower premium di kawasan SCBD yang akan segera hadir. Desain modern dengan standar internasional.', 'pic_name' => 'Rudi Hartono', 'pic_phone' => '628567890123'],
            ['title' => 'Permata Bintaro Residence','location' => 'Bintaro, Tangerang',  'price' => 'Rp 1,2 Miliar','type' => 'rumah',     'status' => 'available', 'featured' => false, 'sort_order' => 6, 'description' => 'Rumah mewah di kawasan Bintaro dengan desain elegan dan lingkungan keamanan 24 jam.', 'pic_name' => 'Citra Dewi', 'pic_phone' => '628678901234'],
        ];
        foreach ($projects as $data) {
            $slug = \Illuminate\Support\Str::slug($data['title']);
            Project::updateOrCreate(['slug' => $slug], array_merge($data, ['slug' => $slug]));
        }

        // Sample properties for projects
        $greenValley = Project::where('slug', 'green-valley-residence')->first();
        if ($greenValley) {
            Property::firstOrCreate(['project_id' => $greenValley->id, 'title' => 'GVR Tipe 36/60'], [
                'slug' => 'gvr-tipe-36-60',
                'description' => 'Rumah tipe 36 dengan luas tanah 60m². Terdiri dari 2 kamar tidur, 1 kamar mandi, ruang tamu dan dapur.',
                'type' => 'house',
                'price' => 850000000,
                'location' => 'Depok',
                'status' => 'available',
                'sort_order' => 1,
            ]);
            Property::firstOrCreate(['project_id' => $greenValley->id, 'title' => 'GVR Tipe 45/80'], [
                'slug' => 'gvr-tipe-45-80',
                'description' => 'Rumah tipe 45 dengan luas tanah 80m². Terdiri dari 3 kamar tidur, 2 kamar mandi, ruang tamu, ruang keluarga dan dapur.',
                'type' => 'house',
                'price' => 1200000000,
                'location' => 'Depok',
                'status' => 'available',
                'sort_order' => 2,
            ]);
        }

        $midlandApt = Project::where('slug', 'midland-apartemen-kuningan')->first();
        if ($midlandApt) {
            Property::firstOrCreate(['project_id' => $midlandApt->id, 'title' => 'Studio 35m²'], [
                'slug' => 'studio-35m2',
                'description' => 'Apartemen studio dengan luas 35m². Dilengkapi AC, water heater, dan dapur mini.',
                'type' => 'apartment',
                'price' => 400000000,
                'location' => 'Kuningan, Jakarta',
                'status' => 'available',
                'sort_order' => 1,
            ]);
            Property::firstOrCreate(['project_id' => $midlandApt->id, 'title' => 'One Bedroom 50m²'], [
                'slug' => 'one-bedroom-50m2',
                'description' => 'Apartemen 1 kamar tidur dengan luas 50m². Memiliki balkon dan pemandangan kota.',
                'type' => 'apartment',
                'price' => 600000000,
                'location' => 'Kuningan, Jakarta',
                'status' => 'available',
                'sort_order' => 2,
            ]);
            Property::firstOrCreate(['project_id' => $midlandApt->id, 'title' => 'Two Bedroom 75m²'], [
                'slug' => 'two-bedroom-75m2',
                'description' => 'Apartemen 2 kamar tidur dengan luas 75m². Dilengkapi kamar mandi ensuite dan ruang tamu yang luas.',
                'type' => 'apartment',
                'price' => 850000000,
                'location' => 'Kuningan, Jakarta',
                'status' => 'sold',
                'sort_order' => 3,
            ]);
        }

        $sentraBisnis = Project::where('slug', 'sentra-bisnis-pluit')->first();
        if ($sentraBisnis) {
            Property::firstOrCreate(['project_id' => $sentraBisnis->id, 'title' => 'Ruko 3 Lantai 150m²'], [
                'slug' => 'ruko-3-lantai-150m2',
                'description' => 'Ruko komersial 3 lantai dengan luas 150m² per lantai. Sangat cocok untuk toko, restoran, atau kantor.',
                'type' => 'ruko',
                'price' => 2500000000,
                'location' => 'Pluit, Jakarta Utara',
                'status' => 'available',
                'sort_order' => 1,
            ]);
            Property::firstOrCreate(['project_id' => $sentraBisnis->id, 'title' => 'Ruko 2 Lantai 120m²'], [
                'slug' => 'ruko-2-lantai-120m2',
                'description' => 'Ruko komersial 2 lantai dengan luas 120m² per lantai. Lokasi strategis di depan jalan raya.',
                'type' => 'ruko',
                'price' => 1800000000,
                'location' => 'Pluit, Jakarta Utara',
                'status' => 'available',
                'sort_order' => 2,
            ]);
        }

        // Sample organizations
        $organizations = [
            ['name' => 'Ikna Abdul Kholik', 'position' => 'Presiden Direktur', 'sort_order' => 1, 'description' => 'Memiliki pengalaman lebih dari 20 tahun di industri properti Indonesia dan berkomitmen untuk memberikan pelayanan terbaik.'],
            ['name' => 'Rini Suryanto', 'position' => 'Direktur Komersial', 'sort_order' => 2, 'description' => 'Spesialis dalam pengembangan properti komersial dengan track record yang proven.'],
            ['name' => 'Ahmad Hidayat', 'position' => 'Direktur Operasional', 'sort_order' => 3, 'description' => 'Mengelola operasional dan strategi pengembangan properti residential di berbagai lokasi strategis.'],
        ];
        foreach ($organizations as $org) {
            Organization::firstOrCreate(['name' => $org['name']], $org);
        }

        // Sample articles
        $articles = [
            [
                'title' => 'Tips Memilih Properti Investasi yang Menguntungkan',
                'slug' => 'tips-memilih-properti-investasi',
                'excerpt' => 'Investasi properti adalah salah satu cara terbaik untuk mengembangkan aset. Pelajari tips dan strategi memilih properti yang tepat untuk kebutuhan Anda.',
                'content' => 'Investasi properti adalah salah satu cara terbaik untuk mengembangkan aset jangka panjang. Namun, memilih properti yang tepat memerlukan pertimbangan matang. Berikut adalah beberapa tips penting dalam memilih properti investasi yang menguntungkan:

1. Lokasi Strategis
   Lokasi adalah faktor terpenting dalam investasi properti. Pilih lokasi yang dekat dengan pusat bisnis, transportasi publik, dan fasilitas umum.

2. Potensi Apresiasi Nilai
   Cari properti di area yang menunjukkan tanda-tanda pertumbuhan dan perkembangan. Area dengan infrastruktur baru dan proyek pembangunan besar sering mengalami peningkatan nilai.

3. Perhitungan ROI
   Hitung return on investment (ROI) dengan matang. Pertimbangkan biaya perawatan, pajak, dan potensi pendapatan rental.

4. Kondisi Properti
   Pastikan properti dalam kondisi baik. Lakukan inspeksi menyeluruh sebelum membeli.

5. Status Kepemilikan
   Verifikasi sertifikat kepemilikan dan pastikan tidak ada masalah hukum.

Investasi properti memang memerlukan modal besar, tapi potensi keuntungannya juga sangat besar. Hubungi kami untuk konsultasi gratis!',
                'author' => 'Tim Midland Properti',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'sort_order' => 1,
            ],
            [
                'title' => 'Perbedaan Rumah Tipe 36, 45, 54 dan Cara Memilihnya',
                'slug' => 'perbedaan-tipe-rumah-36-45-54',
                'excerpt' => 'Ketahui perbedaan rumah dengan tipe 36, 45, 54 dan tips memilih yang sesuai dengan kebutuhan dan budget Anda.',
                'content' => 'Ketika mencari rumah, Anda pasti akan menemukan istilah tipe 36, 45, 54, dan sebagainya. Angka tersebut menunjukkan luas bangunan rumah. Berikut penjelasannya:

RUMAH TIPE 36
- Luas bangunan: 36 meter persegi
- Ideal untuk: Pasangan muda, keluarga kecil, atau investasi
- Keuntungan: Harga terjangkau, biaya pemeliharaan rendah, cocok untuk kavling kecil
- Kekurangan: Ruang terbatas, kurang cocok untuk keluarga besar

RUMAH TIPE 45
- Luas bangunan: 45 meter persegi
- Ideal untuk: Keluarga dengan 2-3 anak
- Keuntungan: Ruang lebih luas, masih terjangkau, biaya operasional sedang
- Kekurangan: Parkir mobil terbatas untuk rumah di kavling standar

RUMAH TIPE 54
- Luas bangunan: 54 meter persegi
- Ideal untuk: Keluarga dengan 3-4 anak
- Keuntungan: Ruang sangat nyaman, garasi memadai, investasi bagus
- Kekurangan: Harga lebih tinggi, biaya pemeliharaan lebih besar

MEMILIH TIPE YANG TEPAT
Pertimbangkan jumlah anggota keluarga, gaya hidup, budget, dan rencana masa depan Anda. Hubungi Midland Properti untuk menemukan rumah tipe yang sempurna untuk Anda!',
                'author' => 'Tim Midland Properti',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'sort_order' => 2,
            ],
            [
                'title' => 'Cara Aman Bertransaksi Properti: Panduan Lengkap',
                'slug' => 'cara-aman-transaksi-properti',
                'excerpt' => 'Panduan lengkap untuk melakukan transaksi properti dengan aman dan menghindari penipuan atau masalah hukum.',
                'content' => 'Transaksi properti melibatkan nilai uang yang sangat besar, sehingga keamanan transaksi menjadi sangat penting. Berikut adalah panduan lengkap untuk bertransaksi properti dengan aman:

SEBELUM MEMBELI
1. Verifikasi kepemilikan - Periksa sertifikat dan lakukan verifikasi ke Badan Pertanahan Nasional (BPN)
2. Serahkan kepada agen terpercaya - Gunakan jasa agen properti bersertifikat
3. Survei lokasi - Kunjungi lokasi berkali-kali untuk memastikan kesesuaian

SAAT TRANSAKSI
1. Gunakan perjanjian tertulis - Selalu buat perjanjian pembelian yang jelas dan tertulis
2. Melibatkan notaris - Semua dokumen harus ditangani oleh notaris yang bersertifikat
3. Jangan transfer uang langsung - Gunakan rekening bank resmi atau escrow service

SETELAH TRANSAKSI
1. Balik nama sertifikat - Segera lakukan balik nama di BPN
2. Asuransi properti - Pertimbangkan asuransi properti dan jiwa untuk perlindungan maksimal
3. Dokumentasi lengkap - Simpan semua dokumen transaksi dengan aman

HINDARI PENIPUAN PROPERTI
- Jangan tergiur dengan harga terlalu murah
- Hindari pembelian tanpa melihat dokumen asli
- Jangan memberikan uang tanda jadi tanpa perjanjian tertulis
- Gunakan agen properti yang terdaftar dan memiliki reputasi baik

Midland Properti siap membantu Anda melakukan transaksi properti dengan aman dan nyaman!',
                'author' => 'Tim Midland Properti',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'sort_order' => 3,
            ],
        ];
        foreach ($articles as $article) {
            Article::firstOrCreate(['slug' => $article['slug']], $article);
        }

        // Dummy testimonials
        $this->call(TestimonialSeeder::class);

        // Dummy careers
        $this->call(CareerSeeder::class);
    }
}
