<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin (Penulis)
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Fira Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ]
        );

        // 2. Buat Kategori (Sesuai Frontend)
        $categories = ['Teknologi', 'Sastra', 'Sains', 'Sejarah', 'Psikologi'];
        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat, 'description' => 'Koleksi artikel bidang ' . $cat]
            );
        }

        // 3. Buat Artikel Dummy
        $data = [
            [
                'title' => 'Masa Depan AI di Indonesia',
                'category_id' => 1,
                'content' => 'Kecerdasan buatan atau AI kini mulai merambah ke berbagai sektor industri di Indonesia...',
                'banner' => 'ai-indonesia.jpg'
            ],
            [
                'title' => 'Analisis Sastra Klasik Era Renaissance',
                'category_id' => 2,
                'content' => 'Sastra klasik memberikan pandangan mendalam tentang bagaimana manusia berpikir pada zamannya...',
                'banner' => 'sastra.jpg'
            ],
            [
                'title' => 'Eksplorasi Ruang Angkasa Terbaru',
                'category_id' => 3,
                'content' => 'NASA baru saja menemukan tanda-tanda air di planet yang jaraknya ribuan tahun cahaya...',
                'banner' => 'space.jpg'
            ]
        ];

        foreach ($data as $item) {
            Article::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'user_id' => $admin->id,
                    'category_id' => $item['category_id'],
                    'title' => $item['title'],
                    'content' => $item['content'],
                    'banner' => $item['banner'],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }
}
