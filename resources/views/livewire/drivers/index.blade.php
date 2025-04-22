<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">
     
    <x-page-menu>
        <div>
            <span class="text-2xl text-white font-sans font-semibold">Data Pengemudi</span>
        </div>

        <div class="flex justify-around gap-3.5">
            <x-button wire:click="addDriver" style='white'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>  
                Tambah 
            </x-button>
    
            <x-button wire:click='exportExcel' style='green'>Cetak .xlsx</x-button>
        </div>
     </x-page-menu>

     <livewire:drivers.table lazy />

     <x-modal title="Tambah Pengemudi" name="addDriver">
    <form wire:submit.prevent="storeDriver" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" wire:model.defer="name" class="w-full mt-1 p-2 border rounded" />
            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nomor Kontak</label>
            <input type="text" wire:model.defer="contact_number" class="w-full mt-1 p-2 border rounded" />
            @error('contact_number') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model.defer="email" class="w-full mt-1 p-2 border rounded" />
            @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <x-button type="submit" style='blue' wire:loading.attr="disabled">
            Simpan
        </x-button>

    </form>
</x-modal>

<x-modal title="Edit Pengemudi" name="editDriver">
    <form wire:submit.prevent="updateDriver" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" wire:model.defer="name" class="w-full mt-1 p-2 border rounded" />
            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nomor Kontak</label>
            <input type="text" wire:model.defer="contact_number" class="w-full mt-1 p-2 border rounded" />
            @error('contact_number') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model.defer="email" class="w-full mt-1 p-2 border rounded" />
            @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="text-right">
            <x-button type="submit" style='blue'>Update</x-button>
        </div>
    </form>
</x-modal>

<x-modal title="Konfirmasi Hapus Pengemudi" name="deleteDriver">
    <div class="space-y-4">
        <p class="text-sm text-gray-700">Apakah Anda yakin ingin menghapus pengemudi ini?</p>
        <div class="flex justify-end gap-2">
            <x-button wire:click="deleteDriver" style="red">Hapus</x-button>
            <x-button wire:click="$dispatch('close-modal', { name: 'deleteDriver' })" style="gray">Batal</x-button>
        </div>
    </div>
</x-modal>


 </div>
