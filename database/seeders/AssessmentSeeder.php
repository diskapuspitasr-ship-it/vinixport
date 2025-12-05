<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\AssessmentSubmission;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. DAFTAR PERTANYAAN (Bank Soal)
        $questions = [
            // --- Soft Skills ---
            [
                'question' => 'Saya dapat mengomunikasikan ide saya dengan jelas kepada orang lain.',
                'type' => 'soft_skill',
            ],
            [
                'question' => 'Saya mampu bekerja sama dengan anggota tim yang baru saya kenal.',
                'type' => 'soft_skill',
            ],
            [
                'question' => 'Saya dapat menyelesaikan konflik dalam tim dengan cara yang baik.',
                'type' => 'soft_skill',
            ],
            [
                'question' => 'Saya mampu mengatur waktu ketika memiliki banyak tugas sekaligus.',
                'type' => 'soft_skill',
            ],
            [
                'question' => 'Saya dapat mengambil keputusan dengan cepat saat situasi mendesak.',
                'type' => 'soft_skill',
            ],

            // --- Digital Skills ---
            [
                'question' => 'Saya terbiasa menggunakan tools digital seperti Google Docs, Sheets, atau Drive.',
                'type' => 'digital_skill',
            ],
            [
                'question' => 'Saya mampu mengikuti arahan tugas atau instruksi mentor yang berbentuk digital (PDF, Notion, GDrive).',
                'type' => 'digital_skill',
            ],
            [
                'question' => 'Saya dapat mengorganisir file dan dokumen digital dengan rapi.',
                'type' => 'digital_skill',
            ],
            [
                'question' => 'Saya mampu mencari informasi atau referensi di internet secara efektif.',
                'type' => 'digital_skill',
            ],
            [
                'question' => 'Saya dapat menggunakan platform komunikasi digital (Zoom, WhatsApp Group, Slack) dengan lancar.',
                'type' => 'digital_skill',
            ],

            // --- Workplace Readiness ---
            [
                'question' => 'Saya biasanya menyelesaikan tugas sebelum atau tepat waktu.',
                'type' => 'workplace_readiness',
            ],
            [
                'question' => 'Saya bisa menerima feedback (kritik/saran) dengan baik dan memperbaikinya.',
                'type' => 'workplace_readiness',
            ],
            [
                'question' => 'Saya cepat beradaptasi ketika diberi tugas baru yang belum pernah saya lakukan.',
                'type' => 'workplace_readiness',
            ],
            [
                'question' => 'Saya dapat bekerja secara mandiri tanpa harus selalu diarahkan.',
                'type' => 'workplace_readiness',
            ],
            [
                'question' => 'Saya memiliki motivasi tinggi untuk mengembangkan skill baru.',
                'type' => 'workplace_readiness',
            ],
        ];

        // 2. INSERT PERTANYAAN KE DATABASE
        foreach ($questions as $q) {
            Assessment::create($q);
        }

        // 3. GENERATE NILAI DUMMY (Untuk User Demo)
        // Ambil user demo (rizki-developer) berdasarkan email dari seeder sebelumnya
        $user = User::where('email', 'john.doe@example.com')->first();

        // Jika user ditemukan, isi nilainya
        if ($user) {
            $assessments = Assessment::all();

            foreach ($assessments as $assessment) {
                AssessmentSubmission::create([
                    'user_id' => $user->id,
                    'assessment_id' => $assessment->id,
                    'value' => rand(3, 5), // Random nilai antara 3 sampai 5 (agar terlihat bagus di demo)
                ]);
            }
        }
    }
}