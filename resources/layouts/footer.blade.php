<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">

        {{-- About --}}
        <div>
            <h3 class="text-white font-semibold mb-3">Perpustakaan Umum</h3>
            <p class="text-sm leading-relaxed">
                Pusat literasi dan informasi untuk mendukung pendidikan,
                penelitian, dan pengembangan masyarakat.
            </p>
        </div>

        {{-- Quick Links --}}
        <div>
            <h3 class="text-white font-semibold mb-3">Navigasi</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('articles.index') }}" class="hover:text-white">Artikel</a></li>
                <li><a href="{{ route('news.index') }}" class="hover:text-white">Berita</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-white">Event</a></li>
                <li><a href="{{ route('library.show', 'profile') }}" class="hover:text-white">Profil</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h3 class="text-white font-semibold mb-3">Kontak</h3>
            <p class="text-sm">
                Email: perpustakaan@example.com<br>
                Telepon: (061) 123456
            </p>
        </div>

    </div>

    <div class="border-t border-gray-700 text-center text-xs py-4">
        © {{ now()->year }} Perpustakaan Umum. All rights reserved.
    </div>
</footer>
