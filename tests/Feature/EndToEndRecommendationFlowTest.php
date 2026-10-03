<?php

namespace Tests\Feature;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use App\Services\KonfigurasiKriteriaService;
use App\Services\MatriksKeputusanService;
use App\Services\RekomendasiSawService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndToEndRecommendationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;
    protected Student $student;
    protected User $adminUser;
    protected Period $activePeriod;
    protected KonfigurasiKriteriaService $criteriaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->criteriaService = app(KonfigurasiKriteriaService::class);

        // 1. Create Active Period
        $this->activePeriod = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        // 2. Create Admin and Student Users
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin SMKN 3',
            'email' => 'admin@smkn3payakumbuh.sch.id',
        ]);

        $this->studentUser = User::factory()->create([
            'role' => 'student',
            'name' => 'Andi Saputra',
            'email' => 'andi.saputra@smkn3payakumbuh.sch.id',
        ]);

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'nis' => '2026001',
            'class_name' => 'KULINER 1',
            'whatsapp' => '08123456789',
            'status' => 'active',
        ]);

        // 3. Create the 12 Extracurriculars matching Section 6
        $ekskulNames = [
            'PASKIBRAKA'    => 'Organisasi',
            'PRAMUKA'       => 'Organisasi',
            'PIK-R'         => 'Organisasi',
            'SILAT TRADISI' => 'Bela Diri',
            'RANDAI'        => 'Seni & Budaya',
            'MARCHING BAND' => 'Seni & Budaya',
            'MODELLING'     => 'Seni & Budaya',
            'KESENIAN'      => 'Seni & Budaya',
            'PADUAN SUARA'  => 'Seni & Budaya',
            'ENGLISH CLUB'  => 'Akademik',
            'JAPANESE CLUB' => 'Akademik',
            'TAHFIDZ'       => 'Keagamaan',
        ];

        foreach ($ekskulNames as $name => $category) {
            Extracurricular::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'category' => $category,
                'is_active' => true,
            ]);
        }

        // 4. Setup proposed criteria (C1-C5) and values
        $this->criteriaService->setupProposedConfiguration();

        // 5. Create questions mapped to C1-C5
        $this->setupQuestions();

        // 6. Setup research target mappings for the 12 extracurriculars
        $this->criteriaService->setupResearchTargetMappings();
    }

    protected function setupQuestions(): void
    {
        $c1 = Criterion::where('code', 'C1')->first();
        $c2 = Criterion::where('code', 'C2')->first();
        $c3 = Criterion::where('code', 'C3')->first();
        $c4 = Criterion::where('code', 'C4')->first();
        $c5 = Criterion::where('code', 'C5')->first();

        // C1 - Minat
        $q1 = Question::create([
            'question' => 'Tingkat minat Anda pada kegiatan ekskul?',
            'category' => 'Ketertarikan',
            'type' => 'likert',
            'criterion_id' => $c1->id,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);
        for ($i = 1; $i <= 5; $i++) {
            QuestionOption::create([
                'question_id' => $q1->id,
                'label' => "Skala $i",
                'value' => $i,
                'sort_order' => $i,
            ]);
        }

        // C2 - Kemampuan
        $q2 = Question::create([
            'question' => 'Tingkat kemampuan fisik atau teknis Anda?',
            'category' => 'Kemampuan',
            'type' => 'likert',
            'criterion_id' => $c2->id,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 2,
        ]);
        for ($i = 1; $i <= 5; $i++) {
            QuestionOption::create([
                'question_id' => $q2->id,
                'label' => "Skala $i",
                'value' => $i,
                'sort_order' => $i,
            ]);
        }

        // C3 - Karakteristik Diri
        $q3 = Question::create([
            'question' => 'Kecenderungan kedisiplinan dan kerja sama Anda?',
            'category' => 'Karakteristik',
            'type' => 'likert',
            'criterion_id' => $c3->id,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 3,
        ]);
        for ($i = 1; $i <= 5; $i++) {
            QuestionOption::create([
                'question_id' => $q3->id,
                'label' => "Skala $i",
                'value' => $i,
                'sort_order' => $i,
            ]);
        }

        // C4 - Pengalaman
        $q4 = Question::create([
            'question' => 'Pengalaman organisasi atau bidang terkait sebelumnya?',
            'category' => 'Pengalaman',
            'type' => 'likert',
            'criterion_id' => $c4->id,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 4,
        ]);
        for ($i = 1; $i <= 5; $i++) {
            QuestionOption::create([
                'question_id' => $q4->id,
                'label' => "Skala $i",
                'value' => $i,
                'sort_order' => $i,
            ]);
        }

        // C5 - Preferensi Aktivitas
        $q5 = Question::create([
            'question' => 'Preferensi aktivitas di lapangan atau luar ruangan?',
            'category' => 'Minat Awal',
            'type' => 'likert',
            'criterion_id' => $c5->id,
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 5,
        ]);
        for ($i = 1; $i <= 5; $i++) {
            QuestionOption::create([
                'question_id' => $q5->id,
                'label' => "Skala $i",
                'value' => $i,
                'sort_order' => $i,
            ]);
        }

        // Qualitative textarea (unmapped)
        Question::create([
            'question' => 'Ceritakan motivasi singkat Anda:',
            'category' => 'Pengalaman',
            'type' => 'textarea',
            'criterion_id' => null,
            'is_required' => false,
            'is_active' => true,
            'sort_order' => 6,
        ]);
    }

    public function test_complete_end_to_end_flow_from_questionnaire_to_saw_to_registration_and_admin(): void
    {
        // 1. Student Dashboard initial visit (before questionnaire)
        $dashResponse = $this->actingAs($this->studentUser)->get('/siswa/dashboard');
        $dashResponse->assertOk();
        $dashResponse->assertSee('Kuesioner Belum Diisi');

        // 2. Student fills questionnaire
        $questions = Question::where('is_active', true)->where('type', '!=', 'textarea')->with('options')->get();
        $answers = [];
        // Student provides profile: C1=5, C2=4, C3=5, C4=3, C5=5 (which perfectly matches PASKIBRAKA target)
        $scores = [5, 4, 5, 3, 5];
        foreach ($questions as $idx => $q) {
            $targetValue = (float) ($scores[$idx] ?? 4);
            $option = $q->options->firstWhere('value', $targetValue) ?? $q->options->first();
            $answers[$q->id] = (string) $option->id;
        }

        $postKuesioner = $this->actingAs($this->studentUser)->post('/siswa/kuesioner', [
            'answers' => $answers,
            'is_final' => '1',
        ]);
        $postKuesioner->assertRedirect('/siswa/kuesioner/analisis');

        // 3. Student views hasil / analisis
        $hasilResponse = $this->actingAs($this->studentUser)->get('/siswa/kuesioner/hasil');
        $hasilResponse->assertOk();
        $hasilResponse->assertSee('Hasil Rekomendasi Ekstrakurikuler');
        $hasilResponse->assertSee('Skor Kecocokan');

        // 4. Verify SAW recommendation is persisted
        $this->assertDatabaseHas('recommendations', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'method_name' => 'SAW',
        ]);
        $this->assertDatabaseCount('recommendation_items', 12);

        // 5. Student views recommendation index
        $rekomendasiResponse = $this->actingAs($this->studentUser)->get('/siswa/rekomendasi');
        $rekomendasiResponse->assertOk();
        $rekomendasiResponse->assertSee('Pilihan Paling Sesuai');
        // Because student answers [5,4,5,3,5] exactly matched Paskibraka targets [5,4,5,3,5], Paskibraka has score 1.0000 (100%)
        $rekomendasiResponse->assertSee('PASKIBRAKA');

        // 6. Student views detail of recommendation #1 (Paskibraka)
        $paskibraka = Extracurricular::where('name', 'PASKIBRAKA')->first();
        $showResponse = $this->actingAs($this->studentUser)->get("/siswa/rekomendasi/{$paskibraka->id}");
        $showResponse->assertOk();
        $showResponse->assertSee('PASKIBRAKA');
        $showResponse->assertSee('Pilih dan Ajukan Pendaftaran');

        // 7. Student visits registration form with preselected Paskibraka
        $pendaftaranForm = $this->actingAs($this->studentUser)->get("/siswa/pendaftaran?ekskul_id={$paskibraka->id}");
        $pendaftaranForm->assertOk();
        $pendaftaranForm->assertSee('Formulir Pendaftaran Ekstrakurikuler');
        $pendaftaranForm->assertSee('PASKIBRAKA');

        // 8. Student submits registration
        $postPendaftaran = $this->actingAs($this->studentUser)->post('/siswa/pendaftaran', [
            'extracurricular_id' => $paskibraka->id,
            'motivation' => 'Saya bertekad menjadi anggota Paskibraka berprestasi.',
            'agreement' => '1',
        ]);
        $postPendaftaran->assertRedirect('/siswa/pendaftaran/sukses');

        $this->assertDatabaseHas('registrations', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'extracurricular_id' => $paskibraka->id,
            'status' => 'submitted',
        ]);

        $reg = Registration::where('student_id', $this->student->id)->first();
        $this->assertNotNull($reg);

        // 9. Student views success page & history
        $suksesResponse = $this->actingAs($this->studentUser)->get('/siswa/pendaftaran/sukses');
        $suksesResponse->assertOk();
        $suksesResponse->assertSee($reg->registration_number);
        $suksesResponse->assertSee('PASKIBRAKA');

        $riwayatResponse = $this->actingAs($this->studentUser)->get('/siswa/riwayat');
        $riwayatResponse->assertOk();
        $riwayatResponse->assertSee($reg->registration_number);
        $riwayatResponse->assertSee('Terkirim');

        // 10. Student dashboard now displays registration status and recommendations
        $dashUpdated = $this->actingAs($this->studentUser)->get('/siswa/dashboard');
        $dashUpdated->assertOk();
        $dashUpdated->assertSee('Submitted');
        $dashUpdated->assertSee('PASKIBRAKA');
        $dashUpdated->assertSee('Rekomendasi Teratas Untukmu');

        // 11. Admin views and updates registration
        $adminList = $this->actingAs($this->adminUser)->get('/admin/pendaftaran');
        $adminList->assertOk();
        $adminList->assertSee('Andi Saputra');
        $adminList->assertSee('PASKIBRAKA');

        $adminShow = $this->actingAs($this->adminUser)->get("/admin/pendaftaran/{$reg->id}");
        $adminShow->assertOk();
        $adminShow->assertSee('Andi Saputra');

        // Admin updates status to reviewed
        $updateReviewed = $this->actingAs($this->adminUser)->patch("/admin/pendaftaran/{$reg->id}/status", [
            'status' => 'reviewed',
            'notes' => 'Berkas lengkap dan sesuai kriteria.',
        ]);
        $updateReviewed->assertRedirect("/admin/pendaftaran/{$reg->id}");

        $this->assertDatabaseHas('registrations', [
            'id' => $reg->id,
            'status' => 'reviewed',
        ]);

        // Admin updates status to accepted
        $updateAccepted = $this->actingAs($this->adminUser)->patch("/admin/pendaftaran/{$reg->id}/status", [
            'status' => 'accepted',
            'notes' => 'Selamat, resmi diterima sebagai anggota Paskibraka SMKN 3 Payakumbuh.',
        ]);
        $updateAccepted->assertRedirect("/admin/pendaftaran/{$reg->id}");

        $this->assertDatabaseHas('registrations', [
            'id' => $reg->id,
            'status' => 'accepted',
        ]);

        // 12. Student verifies updated status in riwayat
        $finalRiwayat = $this->actingAs($this->studentUser)->get('/siswa/riwayat');
        $finalRiwayat->assertOk();
        $finalRiwayat->assertSee('Diterima');
    }

    public function test_readiness_transitions_from_not_ready_to_ready(): void
    {
        // Create a new student without answers
        $user2 = User::factory()->create(['role' => 'student', 'name' => 'Siswa Baru']);
        $student2 = Student::create([
            'user_id' => $user2->id,
            'nis' => '2026777',
            'class_name' => 'TKJ',
        ]);

        $matrixService = app(MatriksKeputusanService::class);
        $sawService = app(RekomendasiSawService::class);

        // Before answering questionnaire: matrix & SAW are NOT_READY
        $matrixBefore = $matrixService->build($student2, $this->activePeriod);
        $this->assertEquals('NOT_READY', $matrixBefore['status']);

        $sawBefore = $sawService->recommend($student2, $this->activePeriod, persist: false);
        $this->assertEquals('NOT_READY', $sawBefore['status']);
        $this->assertEmpty($sawBefore['ranking']);

        // After student answers questionnaire
        $questions = Question::where('is_active', true)->where('type', '!=', 'textarea')->get();
        foreach ($questions as $q) {
            \App\Models\QuestionnaireAnswer::create([
                'student_id' => $student2->id,
                'period_id' => $this->activePeriod->id,
                'question_id' => $q->id,
                'answer_value' => '4',
            ]);
        }

        // Matrix & SAW are now READY
        $matrixAfter = $matrixService->build($student2, $this->activePeriod);
        $this->assertEquals('READY_FOR_SAW', $matrixAfter['status']);

        $sawAfter = $sawService->recommend($student2, $this->activePeriod, persist: false);
        $this->assertEquals('READY', $sawAfter['status']);
        $this->assertCount(12, $sawAfter['ranking']);
        $this->assertEquals(1, $sawAfter['ranking'][0]['rank']);
    }
}
