<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Nilai default model untuk atribut.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => 'student',
    ];

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ambil atribut yang harus di-cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Periksa apakah user memiliki role admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Periksa apakah user memiliki role student.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Relasi ke profil Siswa.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Ambil atau buat profil siswa untuk user ini secara aman.
     */
    public function getOrCreateStudent(): Student
    {
        if ($this->relationLoaded('student') && $this->getRelation('student') !== null) {
            return $this->getRelation('student');
        }

        $student = $this->student()->firstOrCreate([], [
            'status' => 'active',
        ]);

        $this->setRelation('student', $student);

        return $student;
    }
}
