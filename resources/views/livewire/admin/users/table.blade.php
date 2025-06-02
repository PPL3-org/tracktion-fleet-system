{{-- resources/views/livewire/admin/users/table.blade.php --}}
<div>
    {{-- Baris untuk Pencarian dan Jumlah Item per Halaman --}}
    <div class="flex items-center justify-between p-4 mb-2 bg-gray-50 border-b border-gray-200">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 placeholder-gray-400"
                   placeholder="Cari nama atau email...">
        </div>
        <div class="flex items-center">
            <label class="text-xs font-medium text-gray-900 mr-2">Per Halaman</label>
            <select wire:model.live="itemsPerPage"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    {{-- Tabel Data Admin --}}
    <div class="overflow-x-auto bg-white relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-4 py-3">ID</th>
                    <th scope="col" class="px-4 py-3">Nama</th>
                    <th scope="col" class="px-4 py-3">Email</th>
                    <th scope="col" class="px-4 py-3">Tanggal Dibuat</th>
                    <th scope="col" class="px-4 py-3">Aktivitas Terakhir</th>
                    <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $user->id }}</td>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">{{ $user->last_seen_formatted }}</td>
                        <td class="px-4 py-3 text-center">
                            <button wire:click="triggerDelete({{ $user->id }})"
                                    class="text-red-600 hover:text-red-800 font-medium"
                                    title="Hapus {{ $user->name }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                            Tidak ada data admin yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi --}}
    @if ($users->hasPages())
    <div class="py-4 px-2">
        {{ $users->links() }}
    </div>
    @endif
</div>