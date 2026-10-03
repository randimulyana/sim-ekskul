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
     * Jalankan database seeder.
     *
     * PENTING:
     * // DATA DEMO — BUKAN DATA RESMI SEKOLAH
     * Semua entri di bawah hanya untuk keperluan pengembangan dan pengujian.
     */
    public function run(): void
    {
        // 1. Akun Demo Admin
        User::updateOrCreate(
            ['email' => 'admin@smkn3payakumbuh.sch.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Demo Siswa & Profil
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

        // 3. Periode Aktif Demo
        Period::updateOrCreate(
            ['name' => 'Tahun Pelajaran 2026/2027'],
            [
                'start_date' => '2026-08-01',
                'end_date' => '2026-09-30',
                'is_active' => true,
            ]
        );

        // 4. Demo Ekstrakurikuler (Data Observasi Awal Saja — Bukan Daftar Final Resmi)
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

        // 5. Demo Pertanyaan & Opsi Kuesioner
        $questions = [
            // STEP 1: Minat Awal
            [
                'question' => 'Bagaimana cara kamu belajar hal baru yang paling menyenangkan?',
                'category' => 'Minat Awal',
                'type' => 'radio',
                'sort_order' => 1,
                'is_required' => true,
                'options' => [
                    ['label' => 'Praktik langsung, bergerak, dan simulasi fisik (Kinestetik)', 'value' => 5],
                    ['label' => 'Melihat gambar, demonstrasi visual, atau video (Visual)', 'value' => 4],
                    ['label' => 'Mendengarkan penjelasan, diskusi, dan irama bunyi (Auditori)', 'value' => 3],
                ],
            ],
            [
                'question' => 'Seberapa sering kamu menyukai aktivitas yang menuntut ketahanan fisik di luar ruangan?',
                'category' => 'Minat Awal',
                'type' => 'likert',
                'sort_order' => 2,
                'is_required' => true,
                'options' => [
                    ['label' => '1 - Sangat Jarang', 'value' => 1],
                    ['label' => '2 - Jarang', 'value' => 2],
                    ['label' => '3 - Netral', 'value' => 3],
                    ['label' => '4 - Sering', 'value' => 4],
                    ['label' => '5 - Sangat Sering', 'value' => 5],
                ],
            ],
            // STEP 2: Ketertarikan
            [
                'question' => 'Pilih bidang kegiatan yang paling membuatmu antusias:',
                'category' => 'Ketertarikan',
                'type' => 'checkbox',
                'sort_order' => 3,
                'is_required' => true,
                'options' => [
                    ['label' => 'Kepemimpinan & Baris Berbaris', 'value' => 5],
                    ['label' => 'Kepanduan & Alam Bebas', 'value' => 5],
                    ['label' => 'Seni Musik & Korps Irama', 'value' => 5],
                    ['label' => 'Seni Bela Diri Tradisional Minangkabau', 'value' => 5],
                    ['label' => 'Bahasa Asing & Komunikasi Publik', 'value' => 5],
                    ['label' => 'Keagamaan & Hafalan Al-Qur\'an', 'value' => 5],
                ],
            ],
            [
                'question' => 'Apakah kamu tertarik untuk tampil atau berkompetisi mewakili nama sekolah?',
                'category' => 'Ketertarikan',
                'type' => 'radio',
                'sort_order' => 4,
                'is_required' => true,
                'options' => [
                    ['label' => 'Sangat Tertarik', 'value' => 5],
                    ['label' => 'Cukup Tertarik', 'value' => 3],
                    ['label' => 'Belum Tertarik', 'value' => 1],
                ],
            ],
            // STEP 3: Karakteristik
            [
                'question' => 'Dalam menyelesaikan suatu kegiatan, gaya kerja seperti apa yang paling kamu sukai?',
                'category' => 'Karakteristik',
                'type' => 'radio',
                'sort_order' => 5,
                'is_required' => true,
                'options' => [
                    ['label' => 'Bekerja dalam tim besar yang solid dan terstruktur', 'value' => 5],
                    ['label' => 'Bekerja dalam kelompok kecil yang fleksibel', 'value' => 4],
                    ['label' => 'Bekerja mandiri secara independen', 'value' => 3],
                ],
            ],
            [
                'question' => 'Tingkat kepercayaan diri kamu saat berinteraksi dengan orang-orang baru:',
                'category' => 'Karakteristik',
                'type' => 'likert',
                'sort_order' => 6,
                'is_required' => true,
                'options' => [
                    ['label' => '1 - Kurang Percaya Diri', 'value' => 1],
                    ['label' => '2 - Cukup Ragu', 'value' => 2],
                    ['label' => '3 - Sedang / Wajar', 'value' => 3],
                    ['label' => '4 - Percaya Diri', 'value' => 4],
                    ['label' => '5 - Sangat Percaya Diri', 'value' => 5],
                ],
            ],
            [
                'question' => 'Seberapa mudah kamu beradaptasi dengan aturan kedisiplinan yang ketat?',
                'category' => 'Karakteristik',
                'type' => 'radio',
                'sort_order' => 7,
                'is_required' => true,
                'options' => [
                    ['label' => 'Sangat mudah dan terbiasa berdisiplin', 'value' => 5],
                    ['label' => 'Dapat beradaptasi dengan waktu', 'value' => 3],
                    ['label' => 'Lebih menyukai kegiatan yang santai dan luwes', 'value' => 2],
                ],
            ],
            // STEP 4: Pengalaman
            [
                'question' => 'Apakah kamu pernah mengikuti kegiatan ekstrakurikuler atau kepanitiaan semasa SMP/MTs?',
                'category' => 'Pengalaman',
                'type' => 'radio',
                'sort_order' => 8,
                'is_required' => true,
                'options' => [
                    ['label' => 'Pernah aktif sebagai pengurus / inti', 'value' => 5],
                    ['label' => 'Pernah menjadi anggota biasa', 'value' => 3],
                    ['label' => 'Belum pernah mengikuti kegiatan apapun', 'value' => 1],
                ],
            ],
            [
                'question' => 'Apakah kamu memiliki pengalaman dasar di bidang seni panggung, bela diri, atau bahasa asing?',
                'category' => 'Pengalaman',
                'type' => 'radio',
                'sort_order' => 9,
                'is_required' => true,
                'options' => [
                    ['label' => 'Ya, memiliki pengalaman aktif dan pernah berlatih', 'value' => 5],
                    ['label' => 'Pernah sedikit belajar secara otodidak', 'value' => 3],
                    ['label' => 'Belum memiliki pengalaman sama sekali', 'value' => 1],
                ],
            ],
            [
                'question' => 'Ceritakan secara singkat motivasi atau harapanmu dalam mengikuti ekstrakurikuler di SMKN 3 Payakumbuh:',
                'category' => 'Pengalaman',
                'type' => 'textarea',
                'sort_order' => 10,
                'is_required' => false,
                'options' => [],
            ],
            // STEP 5: Kemampuan
            [
                'question' => 'Penilaian mandiri terhadap ketahanan fisik dan stamina kamu:',
                'category' => 'Kemampuan',
                'type' => 'likert',
                'sort_order' => 11,
                'is_required' => true,
                'options' => [
                    ['label' => '1 - Sangat Rendah', 'value' => 1],
                    ['label' => '2 - Kurang', 'value' => 2],
                    ['label' => '3 - Cukup', 'value' => 3],
                    ['label' => '4 - Baik', 'value' => 4],
                    ['label' => '5 - Sangat Prima', 'value' => 5],
                ],
            ],
            [
                'question' => 'Penilaian mandiri terhadap kepekaan ritme irama musik / kesenian vokal gerak:',
                'category' => 'Kemampuan',
                'type' => 'likert',
                'sort_order' => 12,
                'is_required' => true,
                'options' => [
                    ['label' => '1 - Kurang Peka', 'value' => 1],
                    ['label' => '2 - Cukup Ragu', 'value' => 2],
                    ['label' => '3 - Sedang', 'value' => 3],
                    ['label' => '4 - Baik', 'value' => 4],
                    ['label' => '5 - Sangat Peka', 'value' => 5],
                ],
            ],
            [
                'question' => 'Penilaian mandiri terhadap minat mempelajari bahasa asing atau hafalan:',
                'category' => 'Kemampuan',
                'type' => 'likert',
                'sort_order' => 13,
                'is_required' => true,
                'options' => [
                    ['label' => '1 - Kurang Tertarik', 'value' => 1],
                    ['label' => '2 - Biasa Saja', 'value' => 2],
                    ['label' => '3 - Cukup Tertarik', 'value' => 3],
                    ['label' => '4 - Antusias', 'value' => 4],
                    ['label' => '5 - Sangat Antusias', 'value' => 5],
                ],
            ],
        ];

        foreach ($questions as $qData) {
            $options = $qData['options'];
            unset($qData['options']);

            $q = \App\Models\Question::updateOrCreate(
                ['question' => $qData['question']],
                array_merge($qData, ['is_active' => true])
            );

            // Buat ulang opsi
            $q->options()->delete();
            $optOrder = 1;
            foreach ($options as $opt) {
                \App\Models\QuestionOption::create([
                    'question_id' => $q->id,
                    'label' => $opt['label'],
                    'value' => $opt['value'],
                    'sort_order' => $optOrder++,
                ]);
            }
        }

        // 6. Kriteria Phase 4 yang Diusulkan, Nilai Indikator & Pemetaan Pertanyaan
        $criteriaService = app(\App\Services\KonfigurasiKriteriaService::class);
        $criteriaService->setupProposedConfiguration();

        // 7. Pemetaan Target Penelitian untuk 12 Ekstrakurikuler (Baseline Phase 6)
        $criteriaService->setupResearchTargetMappings();
    }
}
