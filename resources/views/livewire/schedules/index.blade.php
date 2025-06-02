<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">
     
    <x-page-menu>
    <div>
        <span class="text-2xl text-white font-sans font-semibold">Jadwal Pengiriman</span>
    </div>

    <div wire:click="addShipmentSchedule" class="flex justify-around gap-3.5">
        <x-button style='white' >
            Tambah Jadwal
        </x-button>

    </div>
    </x-page-menu>
    
    <livewire:schedules.tables lazy />

    <x-modal title="Buat Jadwal Pengiriman" name="create-shipment-schedule">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label for="client" class="block text-sm font-medium text-gray-700">Klien</label>
                <div class="mt-1">
                    <input
                        type="text"
                        wire:model="client"
                        id="client"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                    @error('inspection_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="delivery_price" class="block text-sm font-medium text-gray-700">Harga Pengiriman</label>
                <div class="mt-1">
                    <input
                        type="number"
                        wire:model="delivery_price"
                        id="delivery_price"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                    @error('inspection_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="departure_date" class="block text-sm font-medium text-gray-700">Tanggal Keberangkatan</label>
                <div class="mt-1">
                    <input
                        type="datetime-local"
                        wire:model="departure_date"
                        id="departure_date"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                    @error('inspection_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-x-3">
                <x-button type="button" x-on:click="$dispatch('close-modal', 'create-shipment-schedule')" style="white">
                    Batal
                </x-button>
                <x-button type="submit" style="dark">
                    Simpan
                </x-button>
            </div>
        </form>
    </x-modal>
 </div>