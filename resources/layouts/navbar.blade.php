<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                Perpustakaan Umum
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">

                <a href="{{ route('home') }}"
                   class="hover:text-blue-600 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                    Beranda
                </a>

                <a href="{{ route('articles.index') }}"
                   class="hover:text-blue-600 {{ request()->routeIs('articles.*') ? 'text-blue-600' : '' }}">
                    Artikel
                </a>

                <a href="{{ route('news.index') }}"
                   class="hover:text-blue-600 {{ request()->routeIs('news.*') ? 'text-blue-600' : '' }}">
                    Berita
                </a>

                <a href="{{ route('events.index') }}"
                   class="hover:text-blue-600 {{ request()->routeIs('events.*') ? 'text-blue-600' : '' }}">
                    Event
                </a>

                {{-- Library Dropdown --}}
                <div class="relative group">
                    <button class="hover:text-blue-600 flex items-center gap-1">
                        Tentang Perpustakaan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        class="absolute left-0 mt-2 w-52 bg-white border rounded-lg shadow-lg hidden group-hover:block">
                        <a href="{{ route('library.show', 'profile') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Profil
                        </a>
                        <a href="{{ route('library.show', 'service') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Layanan
                        </a>
                        <a href="{{ route('library.show', 'rule') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Tata Tertib
                        </a>
                        <a href="{{ route('library.show', 'facility') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Fasilitas
                        </a>
                        <a href="{{ route('library.show', 'contact') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Kontak
                        </a>
                    </div>
                </div>

                {{-- Admin --}}
                @auth
                    <a href="/admin"
                       class="text-blue-600 font-semibold border border-blue-600 px-4 py-1.5 rounded hover:bg-blue-50">
                        Admin
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>
