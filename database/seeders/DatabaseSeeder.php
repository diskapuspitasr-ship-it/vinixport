<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Certificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'slug' => 'super-admin',
            'email_verified_at' => now(),
        ]);

        // 2. Buat Akun User Demo
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => Hash::make('password'),
            'slug' => 'rizki-developer',
            'bio' => 'about me here...',
            'jabatan' => 'Fullstack Developer',
            'email_verified_at' => now(),
        ]);

        // 3. Isi Data Skill untuk User Demo
        Skill::create([
            'user_id' => $user->id,
            'skills' => [
                [
                    'skill_name' => 'Laravel',
                    'level' => 'Expert',
                ],
                [
                    'skill_name' => 'React.js',
                    'level' => 'Intermediate',
                ],
                [
                    'skill_name' => 'Tailwind CSS',
                    'level' => 'Advanced',
                ],
                [
                    'skill_name' => 'DevOps',
                    'level' => 'Beginner',
                ],
            ],
        ]);

        // 4. Isi Data Projects untuk User Demo
        Project::create([
            'user_id' => $user->id,
            'project_title' => 'E-Commerce Platform',
            'description' => 'Aplikasi toko online lengkap dengan fitur payment gateway dan rajaongkir.',
            'project_link' => 'https://github.com/rizki/ecommerce',
            'tags' => ['Laravel', 'Midtrans', 'Bootstrap'],
            'image_path' => 'https://via.placeholder.com/600x400.png?text=Project+1',
        ]);

        Project::create([
            'user_id' => $user->id,
            'project_title' => 'Sistem Informasi Sekolah',
            'description' => 'Manajemen data siswa, guru, dan nilai akademik berbasis web.',
            'project_link' => 'https://github.com/rizki/sisko',
            'tags' => ['PHP Native', 'MySQL'],
            'image_path' => 'https://via.placeholder.com/600x400.png?text=Project+2',
        ]);

        // 5. Isi Data Certificates untuk User Demo
        Certificate::create([
            'user_id' => $user->id,
            'certificate_title' => 'Laravel Expert Developer',
            'issuer_organization' => 'Laracasts',
            'date_issued' => '2023-08-15',
            'image_path' => 'https://via.placeholder.com/800x600.png?text=Certificate+1',
        ]);

        Certificate::create([
            'user_id' => $user->id,
            'certificate_title' => 'Frontend Master',
            'issuer_organization' => 'Udemy',
            'date_issued' => '2022-12-10',
            'image_path' => 'https://via.placeholder.com/800x600.png?text=Certificate+2',
        ]);

        $this->call([AssessmentSeeder::class]);

        $this->command->info('Seeder berhasil dijalankan! Login: john.doe@example.com | Pass: password123');
    }
}
