<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuestionnaireCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Kuesioner',
            'email' => 'admin.kuesioner@smkn3payakumbuh.sch.id',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_questionnaire_index_page(): void
    {
        $question = Question::create([
            'question_text' => 'Bagaimana gaya belajar yang paling nyaman untukmu?',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/kuesioner');

        $response->assertOk();
        $response->assertSee('Kelola Kuesioner');
        $response->assertSee('Bagaimana gaya belajar yang paling nyaman untukmu?');
    }

    public function test_admin_can_view_create_question_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/kuesioner/create');

        $response->assertOk();
        $response->assertSee('Tambah Pertanyaan Kuesioner');
    }

    public function test_admin_can_store_question_with_options(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kuesioner', [
            'question_text' => 'Bidang apa yang paling kamu sukai?',
            'category' => 'Minat & Ketertarikan',
            'type' => 'radio',
            'order' => 2,
            'is_active' => true,
            'options' => [
                ['text' => 'Seni Musik', 'score' => 5],
                ['text' => 'Olahraga & Fisik', 'score' => 4],
                ['text' => 'Teknologi Informasi', 'score' => 5],
            ],
        ]);

        $response->assertRedirect('/admin/kuesioner');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('questions', [
            'question' => 'Bidang apa yang paling kamu sukai?',
            'category' => 'Minat & Ketertarikan',
            'type' => 'radio',
        ]);

        $question = Question::where('question', 'Bidang apa yang paling kamu sukai?')->first();
        $this->assertNotNull($question);
        $this->assertDatabaseHas('question_options', [
            'question_id' => $question->id,
            'label' => 'Seni Musik',
        ]);
        $this->assertDatabaseHas('question_options', [
            'question_id' => $question->id,
            'label' => 'Olahraga & Fisik',
        ]);
    }

    public function test_admin_can_view_edit_question_page(): void
    {
        $question = Question::create([
            'question_text' => 'Apakah kamu suka berbicara di depan umum?',
            'category' => 'Karakteristik Diri',
            'type' => 'radio',
            'order' => 3,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/kuesioner/{$question->id}/edit");

        $response->assertOk();
        $response->assertSee('Edit Pertanyaan Kuesioner');
        $response->assertSee('Apakah kamu suka berbicara di depan umum?');
    }

    public function test_admin_can_update_question_and_options(): void
    {
        $question = Question::create([
            'question_text' => 'Tingkat kemampuan fisik kamu',
            'category' => 'Kemampuan',
            'type' => 'radio',
            'order' => 4,
            'is_active' => true,
        ]);

        QuestionOption::create([
            'question_id' => $question->id,
            'option_text' => 'Kurang',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/kuesioner/{$question->id}", [
            'question_text' => 'Seberapa baik ketahanan fisik kamu?',
            'category' => 'Kemampuan',
            'type' => 'radio',
            'order' => 4,
            'is_active' => true,
            'options' => [
                ['text' => 'Cukup Baik', 'score' => 3],
                ['text' => 'Sangat Baik', 'score' => 5],
            ],
        ]);

        $response->assertRedirect('/admin/kuesioner');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'question' => 'Seberapa baik ketahanan fisik kamu?',
        ]);

        $this->assertDatabaseHas('question_options', [
            'question_id' => $question->id,
            'label' => 'Sangat Baik',
        ]);

        $this->assertDatabaseMissing('question_options', [
            'question_id' => $question->id,
            'label' => 'Kurang',
        ]);
    }

    public function test_admin_can_toggle_question_active_status(): void
    {
        $question = Question::create([
            'question_text' => 'Pertanyaan uji coba toggle status',
            'category' => 'Pengalaman',
            'type' => 'likert',
            'order' => 5,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/kuesioner/{$question->id}/toggle");

        $response->assertRedirect('/admin/kuesioner');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'is_active' => 0,
        ]);

        // Toggle back
        $response2 = $this->actingAs($this->admin)->patch("/admin/kuesioner/{$question->id}/toggle");
        $response2->assertRedirect('/admin/kuesioner');

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'is_active' => 1,
        ]);
    }

    public function test_admin_can_delete_question(): void
    {
        $question = Question::create([
            'question_text' => 'Pertanyaan yang akan dihapus',
            'category' => 'Pengalaman',
            'type' => 'textarea',
            'order' => 6,
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/kuesioner/{$question->id}");

        $response->assertRedirect('/admin/kuesioner');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('questions', [
            'id' => $question->id,
        ]);
    }

    public function test_store_question_validation_fails_for_missing_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kuesioner', [
            'category' => 'Minat Awal',
        ]);

        $response->assertSessionHasErrors(['question_text', 'type']);
    }
}
