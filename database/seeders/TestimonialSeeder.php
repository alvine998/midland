<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name'       => 'Budi Santoso',
                'position'   => 'Pengusaha',
                'content'    => 'Midland Properti benar-benar membantu saya menemukan rumah impian di lokasi strategis dengan harga yang sesuai anggaran. Prosesnya cepat, transparan, dan tim sangat profesional. Saya tidak ragu untuk merekomendasikan Midland kepada keluarga dan rekan bisnis.',
                'rating'     => 5,
                'is_active'  => true,
                'sort_order' => 1,
            ],
            [
                'name'       => 'Siti Rahayu',
                'position'   => 'Dokter Spesialis',
                'content'    => 'Awalnya saya ragu memilih properti investasi, tapi konsultan Midland sangat sabar menjelaskan setiap opsi beserta potensi return-nya. Akhirnya saya mendapatkan apartemen yang nilainya sudah naik signifikan dalam 1 tahun. Terima kasih Midland!',
                'rating'     => 5,
                'is_active'  => true,
                'sort_order' => 2,
            ],
            [
                'name'       => 'Hendra Wijaya',
                'position'   => 'Direktur Perusahaan',
                'content'    => 'Kami mencari ruang kantor untuk kantor cabang kami, dan Midland Properti memberikan pilihan terbaik yang sesuai dengan kebutuhan operasional kami. Layanan after-sales mereka juga sangat membantu. Sangat merekomendasikan!',
                'rating'     => 5,
                'is_active'  => true,
                'sort_order' => 3,
            ],
            [
                'name'       => 'Dewi Kusuma',
                'position'   => 'Ibu Rumah Tangga',
                'content'    => 'Proses KPR yang saya khawatirkan ternyata sangat mudah dengan bantuan tim Midland. Mereka membantu dari awal hingga serah terima kunci. Sekarang saya sudah menghuni rumah idaman saya. Luar biasa pelayanannya!',
                'rating'     => 5,
                'is_active'  => true,
                'sort_order' => 4,
            ],
            [
                'name'       => 'Rizky Pratama',
                'position'   => 'Software Engineer',
                'content'    => 'Sebagai pembeli pertama kali, saya merasa sangat terbantu dengan simulasi cicilan yang tersedia di website Midland. Tim mereka responsif dan jujur tentang kelebihan dan kekurangan setiap properti. Pengalaman yang sangat menyenangkan!',
                'rating'     => 4,
                'is_active'  => true,
                'sort_order' => 5,
            ],
            [
                'name'       => 'Anita Permata',
                'position'   => 'Dosen Universitas',
                'content'    => 'Saya sudah bertransaksi dua kali dengan Midland Properti — pertama beli rumah, kedua investasi ruko. Keduanya berjalan lancar tanpa hambatan. Kepercayaan saya terhadap Midland sudah terbukti. Satu-satunya agen properti yang saya rekomendasikan.',
                'rating'     => 5,
                'is_active'  => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
