<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Ibadah Minggu Pagi',
                'description' => 'Ibadah minggu pagi untuk jemaat gereja. Mari bergabung dalam persekutuan dan penyembahan bersama.',
                'total_seats' => 100,
                'available_seats' => 100,
                'start_date' => Carbon::now()->addDays(7)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(7)->setTime(10, 0),
                'location' => 'Gedung Gereja Utama',
                'status' => 'published'
            ],
            [
                'title' => 'Kelas Alkitab Pemuda',
                'description' => 'Kelas Alkitab khusus untuk pemuda dan remaja. Belajar firman Tuhan dengan cara yang menyenangkan dan interaktif.',
                'total_seats' => 50,
                'available_seats' => 50,
                'start_date' => Carbon::now()->addDays(3)->setTime(19, 0),
                'end_date' => Carbon::now()->addDays(3)->setTime(21, 0),
                'location' => 'Ruang Pemuda',
                'status' => 'published'
            ],
            [
                'title' => 'Doa Bersama Keluarga',
                'description' => 'Acara doa bersama untuk keluarga. Mari berdoa untuk kesehatan, pekerjaan, dan berkat keluarga.',
                'total_seats' => 80,
                'available_seats' => 80,
                'start_date' => Carbon::now()->addDays(5)->setTime(18, 30),
                'end_date' => Carbon::now()->addDays(5)->setTime(20, 30),
                'location' => 'Aula Gereja',
                'status' => 'published'
            ],
            [
                'title' => 'Pelayanan Musik',
                'description' => 'Pelayanan musik dan pujian. Bergabunglah dengan tim musik gereja dalam melayani Tuhan.',
                'total_seats' => 30,
                'available_seats' => 30,
                'start_date' => Carbon::now()->addDays(10)->setTime(15, 0),
                'end_date' => Carbon::now()->addDays(10)->setTime(17, 0),
                'location' => 'Ruang Musik',
                'status' => 'published'
            ],
            [
                'title' => 'Konseling Rohani',
                'description' => 'Sesi konseling rohani dengan pendeta. Untuk jemaat yang membutuhkan bimbingan dan nasihat rohani.',
                'total_seats' => 20,
                'available_seats' => 20,
                'start_date' => Carbon::now()->addDays(2)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(2)->setTime(16, 0),
                'location' => 'Ruang Konseling',
                'status' => 'published'
            ],
            [
                'title' => 'Pelatihan Kepemimpinan',
                'description' => 'Pelatihan kepemimpinan untuk pemimpin-pemimpin di gereja. Mengembangkan skill kepemimpinan berdasarkan prinsip Alkitab.',
                'total_seats' => 40,
                'available_seats' => 40,
                'start_date' => Carbon::now()->addDays(14)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(14)->setTime(16, 0),
                'location' => 'Ruang Rapat',
                'status' => 'draft'
            ],
            [
                'title' => 'Retreat Keluarga',
                'description' => 'Retreat keluarga untuk mempererat hubungan keluarga dan iman. Acara 2 hari 1 malam di luar kota.',
                'total_seats' => 60,
                'available_seats' => 60,
                'start_date' => Carbon::now()->addDays(21)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(22)->setTime(17, 0),
                'location' => 'Villa Retreat',
                'status' => 'draft'
            ],
            [
                'title' => 'Pelayanan Anak',
                'description' => 'Pelayanan khusus untuk anak-anak. Belajar firman Tuhan dengan cara yang menyenangkan dan sesuai usia.',
                'total_seats' => 70,
                'available_seats' => 70,
                'start_date' => Carbon::now()->addDays(1)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(1)->setTime(11, 0),
                'location' => 'Ruang Anak',
                'status' => 'published'
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
