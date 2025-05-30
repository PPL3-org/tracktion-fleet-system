{{-- resources/views/livewire/admin/users/index.blade.php --}}
<div x-data="{ sidebarOpenStatePage: false }" {{-- Nama state bisa disesuaikan agar unik jika perlu, atau gunakan nama yg sama jika event toggle global sudah cukup --}}
     x-init="
        // Jika state awal sidebar (misal dari session/cookie/preferensi) perlu dibaca, lakukan di sini.
        // Jika sidebar Anda (livewire:sidebar) defaultnya 'false' (tertutup), maka 'false' di sini juga baik.
        // Anda bisa menyamakan dengan state awal 'open' di sidebar.blade.php Anda.
        // Jika sidebar.blade.php Anda x-data="{ open: false }", maka di sini juga false.
        @if(isset($initialSidebarState)) // Contoh jika Anda passing state dari PHP
            sidebarOpenStatePage = {{ $initialSidebarState ? 'true' : 'false' }};
        @else
            // Coba sinkronkan dengan event listener atau default yang sama dengan sidebar
            // Untuk toggle.window, pastikan state awal ini cocok dengan apa yang diharapkan
            // oleh sidebar agar tidak ada lompatan saat toggle pertama.
            // Jika sidebar punya x-data="{ open: false }", maka di sini juga harus false.
        @endif
     "
     x-on:toggle.window="sidebarOpenStatePage = !sidebarOpenStatePage"
     class="flex flex-col w-full transition-all duration-300 ease-in-out" {{-- class dari contoh Anda --}}
     :class="sidebarOpenStatePage ? 'ml-[16.666667%]' : 'ml-0'" {{-- Sesuaikan persentase ini dengan lebar sidebar Anda (1/6 = 16.666667%) --}}
     :style="sidebarOpenStatePage ? 'width: calc(100% - 16.666667%)' : 'width: 100%'">

    {{-- Bagian header halaman Anda (sesuaikan dengan <x-page-menu> jika ada) --}}
    <div class="p-4 bg-gray-800 text-white rounded-t-md flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Manajemen Akun Admin</h1>
        {{-- Tombol "Tambah Admin" bisa diletakkan di sini jika PBI-nya berkembang --}}
    </div>

    {{-- Menampilkan pesan sukses/error dari Livewire component --}}
    @if(session()->has('lwSuccessMessage'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('lwSuccessMessage') }}
        </div>
    @endif
    @if(session()->has('lwErrorMessage'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('lwErrorMessage') }}
        </div>
    @endif

    {{-- Memanggil Komponen Livewire Tabel --}}
    @livewire('admin.users.table', [], key('admin-users-table'))

    {{-- Modal Konfirmasi Hapus (yang sudah kita buat sebelumnya) --}}
    @if($showDeleteModal && $userToDelete)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- ... Konten Modal ... --}}
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeDeleteModal" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Konfirmasi Hapus Admin
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin menghapus admin: <strong>{{ $userToDelete->name }}</strong> ({{ $userToDelete->email }})?
                                Tindakan ini tidak dapat diurungkan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteUser" type="button"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                    <button wire:click="closeDeleteModal" type="button"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>