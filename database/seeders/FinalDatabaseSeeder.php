<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Event;
use App\Models\LibraryInformation;
use App\Models\Tag;

class FinalDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan pengecekan foreign key agar bisa truncate/bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Bersihkan data lama
        User::truncate();
        Category::truncate();
        Article::truncate();
        Event::truncate();
        LibraryInformation::truncate();
        Tag::truncate();

        // 2. SEED USERS (Admin & Editor)
        $admin = User::create([
            'id' => 1,
            'name' => 'Fira Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $editors = [
            ['id' => 2, 'name' => 'Dr. Anindya Kartika', 'email' => 'anindya@example.com'],
            ['id' => 3, 'name' => 'Prof. Budi Santoso, Ph.D', 'email' => 'budi@example.com'],
            ['id' => 4, 'name' => 'Dr. Sari Wijaya', 'email' => 'sari@example.com'],
            ['id' => 5, 'name' => 'Putri Ramadhani, M.Pd', 'email' => 'putri@example.com'],
            ['id' => 6, 'name' => 'Dr. Ahmad Fauzi', 'email' => 'ahmad@example.com'],
            ['id' => 7, 'name' => 'Rina Kusuma, S.Kom, M.T', 'email' => 'rina@example.com'],
            ['id' => 8, 'name' => 'Dian Sastro, M.A', 'email' => 'dian@example.com'],
            ['id' => 9, 'name' => 'Dr. Linda Permata', 'email' => 'linda@example.com'],
            ['id' => 10, 'name' => 'Arif Budiman, S.Ars, M.Arch', 'email' => 'arif@example.com'],
            ['id' => 11, 'name' => 'Prof. Dr. Bambang Setiawan', 'email' => 'bambang@example.com'],
            ['id' => 12, 'name' => 'Dr. Ratna Sari, S.Si, M.Sc', 'email' => 'ratna@example.com'],
            ['id' => 13, 'name' => 'Maya Angelina, M.Pd', 'email' => 'maya@example.com'],
        ];

        foreach ($editors as $editor) {
            User::create([
                'id' => $editor['id'],
                'name' => $editor['name'],
                'email' => $editor['email'],
                'password' => Hash::make('password123'),
                'role' => 'editor',
            ]);
        }

        // 3. SEED CATEGORIES
        $categories = [
            ['id' => 1, 'name' => 'Internet Of Things', 'slug' => 'internet-of-things', 'description' => 'Membahas konektivitas perangkat.'],
            ['id' => 2, 'name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Koleksi artikel bidang Teknologi.'],
            ['id' => 3, 'name' => 'Sastra', 'slug' => 'sastra', 'description' => 'Koleksi artikel bidang Sastra.'],
            ['id' => 4, 'name' => 'Sains', 'slug' => 'sains', 'description' => 'Koleksi artikel bidang Sains.'],
            ['id' => 5, 'name' => 'Sejarah', 'slug' => 'sejarah', 'description' => 'Koleksi artikel bidang Sejarah.'],
            ['id' => 6, 'name' => 'Psikologi', 'slug' => 'psikologi', 'description' => 'Koleksi artikel bidang Psikologi.'],
            ['id' => 7, 'name' => 'Fiksi', 'slug' => 'fiksi', 'description' => 'Koleksi karya sastra fiksi pilihan.'],
            ['id' => 8, 'name' => 'Non-Fiksi', 'slug' => 'non-fiksi', 'description' => 'Buku pengetahuan dan esai faktual.'],
            ['id' => 9, 'name' => 'Jurnal Ilmiah', 'slug' => 'jurnal-ilmiah', 'description' => 'Publikasi penelitian akademis.'],
            ['id' => 10, 'name' => 'Anak-anak', 'slug' => 'anak-anak', 'description' => 'Bacaan edukatif untuk usia muda.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 4. SEED ARTICLES
        $articles = [
            [
                'id' => 5,
                'user_id' => 2,
                'category_id' => 7,
                'title' => 'Menyelami Kedalaman Literatur Klasik',
                'slug' => 'menyelami-kedalaman-literatur-klasik',
                'banner' => 'https://images.unsplash.com/photo-1419640303358-44f0d27f48e7',
                'content' => 'Literatur klasik Indonesia memiliki tempat istimewa...',
                'status' => 'published'
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'category_id' => 2,
                'title' => 'Revolusi Perpustakaan Digital di Era 5G',
                'slug' => 'revolusi-perpustakaan-digital-5g',
                'banner' => 'https://images.unsplash.com/photo-1537202108838-e7072bad1927',
                'content' => 'Perpustakaan telah berevolusi jauh...',
                'status' => 'published'
            ],
            [
                'id' => 7,
                'user_id' => 4,
                'category_id' => 8,
                'title' => 'Psikologi Membaca dan Empati',
                'slug' => 'psikologi-membaca-empati',
                'banner' => 'https://images.unsplash.com/photo-1592693281721-67ad5dcfa91b',
                'content' => 'Membaca secara literal mengubah struktur otak...',
                'status' => 'published'
            ],
            [
                'id' => 8,
                'user_id' => 5,
                'category_id' => 10,
                'title' => 'Dongeng Nusantara untuk Generasi Alpha',
                'slug' => 'dongeng-nusantara-alpha',
                'banner' => 'https://images.unsplash.com/photo-1599689868384-59cb2b01bb21',
                'content' => 'Kearifan lokal sangat berharga...',
                'status' => 'published'
            ],
            // Tambahkan artikel id 9-16 sesuai data SQL Anda jika diperlukan...
        ];

        foreach ($articles as $art) {
            Article::create($art);
        }

        // 5. SEED EVENTS
        $events = [
            [
                'id' => 1,
                'title' => 'Workshop Literasi Digital',
                'slug' => 'workshop-literasi-digital',
                'category' => 'workshop',
                'banner' => 'https://images.unsplash.com/photo-1596496638641-e240fd67b4c3',
                'description' => 'Pelajari cara memanfaatkan perpustakaan digital.',
                'event_date' => '2026-01-22',
                'event_time' => '14:00 - 16:00 WIB',
                'location' => 'Ruang Seminar Lantai 3',
                'location_type' => 'physical',
                'status' => 'published',
                'status_event' => 'upcoming',
                'user_id' => 1
            ],
            [
                'id' => 3,
                'title' => 'Pameran Manuskrip Nusantara',
                'slug' => 'pameran-manuskrip',
                'category' => 'exhibition',
                'banner' => 'https://images.unsplash.com/photo-1723721229325-b286656e768a',
                'description' => 'Koleksi manuskrip langka AR Immersive.',
                'event_date' => '2026-01-28',
                'event_time' => '10:00 - 17:00 WIB',
                'location' => 'Galeri Utama',
                'location_type' => 'physical',
                'status' => 'published',
                'status_event' => 'ongoing',
                'user_id' => 1
            ],
            [
                'id' => 5,
                'title' => 'Story Time Interaktif Anak',
                'slug' => 'story-time-interaktif',
                'category' => 'workshop',
                'banner' => 'https://images.unsplash.com/photo-1763013259158-8a8370542ddb',
                'description' => 'Sesi mendongeng dengan animasi.',
                'event_date' => '2026-02-05',
                'event_time' => '10:00 - 11:30 WIB',
                'location' => 'Children Corner',
                'location_type' => 'physical',
                'status' => 'published',
                'status_event' => 'full',
                'user_id' => 1
            ],
        ];

        foreach ($events as $evt) {
            Event::create($evt);
        }

        // 6. SEED LIBRARY INFORMATION
        $libInfos = [
            [
                'id' => 1,
                'title' => 'Jam Operasional Perpustakaan',
                'slug' => 'jam-operasional',
                'banner' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da',
                'content' => "Senin - Jumat: 08:00 - 20:00 WIB\nSabtu: 09:00 - 15:00 WIB\nMinggu: Tutup",
                'type' => 'service',
                'status' => 'published',
                'user_id' => 1
            ],
            [
                'id' => 2,
                'title' => 'Kontak & Lokasi',
                'slug' => 'kontak-lokasi',
                'banner' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac',
                'content' => "Alamat: Jl. Perpustakaan No. 12\nEmail: info@digitallib.id\nWA: 08123456789",
                'type' => 'contact',
                'status' => 'published',
                'user_id' => 1
            ],
        ];

        foreach ($libInfos as $info) {
            LibraryInformation::create($info);
        }

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
