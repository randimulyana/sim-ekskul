<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * IMPORTANT:
     * // DEMO DATA — NOT OFFICIAL SCHOOL DATA
     * All entries below are for development and testing purposes only.
     */
    public function run(): void
    {
        // 1. Admin Demo User
        User::updateOrCreate(
            ['email' => 'admin@smkn3payakumbuh.sch.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Student Demo User & Profile
        $studentUser = User::updateOrCreate(
            ['email' => 'andi.saputra@smkn3payakumbuh.sch.id'],
            [
                'name' => 'Andi Saputra',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        Student::updateOrCreate(
            ['user_id' => $studentUser->id],
            [
                'nis' => '2026001',
                'class_name' => 'KULINER 1',
                'whatsapp' => '08123456789',
                'status' => 'active',
            ]
        );

        // 3. Demo Active Period
        Period::updateOrCreate(
            ['name' => 'Tahun Pelajaran 2026/2027'],
            [
                'start_date' => '2026-08-01',
                'end_date' => '2026-09-30',
                'is_active' => true,
            ]
        );

        // 4. Demo Extracurriculars (Initial Observation Data Only — Not Official Final List)
        $ekskuls = [
            [
                'name' => 'PASKIBRAKA',
                'category' => 'Organisasi',
                'description' => 'Pasukan Pengibar Bendera Pusaka yang melatih kedisiplinan tingkat tinggi, ketahanan fisik, kepemimpinan, dan rasa cinta tanah air.',
                'schedule_info' => 'Rabu & Sabtu, 15.30 - 17.30 WIB',
                'location_info' => 'Lapangan Utama SMKN 3 Payakumbuh',
                'coach_name' => 'Drs. Hendri Syahputra, M.Pd.',
                'quota' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'PRAMUKA',
                'category' => 'Organisasi',
                'description' => 'Gerakan kepanduan yang menumbuhkan kemandirian, ketrampilan hidup di alam bebas, jiwa sosial, kepemimpinan, dan kerja sama tim.',
                'schedule_info' => 'Jumat, 14.00 - 17.00 WIB',
                'location_info' => 'Bumi Perkemahan / Area Terbuka Sekolah',
                'coach_name' => 'Rahmat Hidayat, S.Pd.',
                'quota' => 80,
                'is_active' => true,
            ],
            [
                'name' => 'PIK-R',
                'category' => 'Organisasi',
                'description' => 'Pusat Informasi dan Konseling Remaja untuk pendampingan konseling sebaya dan keterampilan hidup remaja.',
                'schedule_info' => 'Kamis, 15.00 - 17.00 WIB',
                'location_info' => 'Ruang BK',
                'coach_name' => 'Pembina PIK-R Terdaftar',
                'quota' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'SILAT TRADISI',
                'category' => 'Bela Diri',
                'description' => 'Pelestarian seni bela diri silat Minangkabau yang memadukan olah fisik ketangkasan dan pertahanan diri.',
                'schedule_info' => 'Selasa & Jumat, 16.00 - 18.00 WIB',
                'location_info' => 'Aula Serbaguna',
                'coach_name' => 'Pelatih Silat Tradisi',
                'quota' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'RANDAI',
                'category' => 'Seni & Budaya',
                'description' => 'Kesenian teater tradisional khas Minangkabau yang memadukan gerakan tari silat, dendang pantun, dan dialog lakon.',
                'schedule_info' => 'Sabtu, 09.00 - 12.00 WIB',
                'location_info' => 'Panggung Kesenian Sekolah',
                'coach_name' => 'Pembina Seni Tradisi',
                'quota' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'MARCHING BAND',
                'category' => 'Seni & Budaya',
                'description' => 'Korps musik dinamis yang menggabungkan instrumen tiup, perkusi, dan aksi formasi visual koreografi spektakuler.',
                'schedule_info' => 'Rabu & Sabtu, 14.00 - 17.00 WIB',
                'location_info' => 'Lapangan Utama',
                'coach_name' => 'Instruktur Marching Band',
                'quota' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'MODELLING',
                'category' => 'Seni & Budaya',
                'description' => 'Pelatihan tata busana, peragaan busana catwalk, pengembangan postur tubuh, serta kepercayaan diri tampil publik.',
                'schedule_info' => 'Senin, 15.30 - 17.30 WIB',
                'location_info' => 'Workshop Tata Busana',
                'coach_name' => 'Pembina Busana',
                'quota' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'KESENIAN',
                'category' => 'Seni & Budaya',
                'description' => 'Wadah eksplorasi seni rupa, seni tari kreasi daerah, dan kriya kreatif untuk mengembangkan ekspresi estetika.',
                'schedule_info' => 'Kamis, 15.30 - 17.30 WIB',
                'location_info' => 'Ruang Seni',
                'coach_name' => 'Guru Seni Budaya',
                'quota' => 35,
                'is_active' => true,
            ],
            [
                'name' => 'PADUAN SUARA',
                'category' => 'Seni & Budaya',
                'description' => 'Pelatihan teknik vokal kelompok, harmonisasi nada lagu nasional, daerah, maupun kontemporer.',
                'schedule_info' => 'Selasa, 15.00 - 17.00 WIB',
                'location_info' => 'Ruang Audio Visual',
                'coach_name' => 'Pembina Vokal',
                'quota' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'ENGLISH CLUB',
                'category' => 'Akademik',
                'description' => 'Klub percakapan aktif bahasa Inggris, debat, story telling, dan penyiapan kompetisi bahasa asing.',
                'schedule_info' => 'Rabu, 15.00 - 17.00 WIB',
                'location_info' => 'Laboratorium Bahasa',
                'coach_name' => 'Guru Bahasa Inggris',
                'quota' => 35,
                'is_active' => true,
            ],
            [
                'name' => 'JAPANESE CLUB',
                'category' => 'Akademik',
                'description' => 'Pengenalan bahasa Jepang dasar (Hiragana/Katakana), percakapan santai, dan pengenalan budaya populer.',
                'schedule_info' => 'Jumat, 14.30 - 16.30 WIB',
                'location_info' => 'Ruang Multimedia',
                'coach_name' => 'Guru Bahasa Asing',
                'quota' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'TAHFIDZ',
                'category' => 'Keagamaan',
                'description' => 'Program hafalan Al-Qur\'an intensif, bimbingan tajwid makhraj, dan pembinaan kepribadian islami mulia.',
                'schedule_info' => 'Senin s/d Kamis, 06.45 - 07.30 WIB',
                'location_info' => 'Musholla Sekolah',
                'coach_name' => 'Ustadz Pembina Rohis',
                'quota' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($ekskuls as $item) {
            Extracurricular::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                array_merge($item, ['slug' => Str::slug($item['name'])])
            );
        }
    }
}
