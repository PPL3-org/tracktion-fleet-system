<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">

    <!-- Toast Notification -->
    <div x-data="{ show: false, message: '', type: '' }"
         x-on:show-toast.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-4 right-4 z-50 max-w-sm w-full"
         x-cloak>
        <div x-bind:class="{
            'bg-green-100 border-green-500 text-green-700': type === 'success',
            'bg-red-100 border-red-500 text-red-700': type === 'error',
            'bg-blue-100 border-blue-500 text-blue-700': type === 'info'
        }" class="border-l-4 p-4 rounded shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <template x-if="type === 'success'">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </template>
                    <template x-if="type === 'error'">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </template>
                </div>
                <div class="ml-3">
                    <p x-text="message" class="text-sm"></p>
                </div>
            </div>
        </div>
    </div>
     
    <x-page-menu>
     <div>
         <span class="text-2xl text-white font-sans font-semibold">Data Truk</span>
     </div>

     <div class="flex justify-around gap-3.5">
        <x-button wire:click="addTruck" style='white' >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>  
            Tambah
        </x-button>

        {{-- Not yet implemented --}}
        <x-button wire:click='exportExcel' style='green'>Cetak .xlsx</x-button>
      </div>
  </x-page-menu>

  <livewire:trucks.table lazy />

  <x-modal title="Tambah Data Truk" name="add-truck" focusable max-width="md">
        <form wire:submit="storeTruck" class="p-6 space-y-4">
            <div>
                <label for="plate_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Plat*</label>
                <input id="plate_number" type="text" wire:model.lazy="plate_number" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Contoh: B 1234 ABC"
                    autocomplete="off">
                @error('plate_number') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model Truk*</label>
                <input id="model" type="text" wire:model.lazy="model" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Contoh: Hino Dutro 130 MD"
                    autocomplete="off">
                @error('model') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="total_distance" class="block text-sm font-medium text-gray-700 mb-1">Total Jarak Tempuh (Km)*</label>
                <input id="total_distance" type="number" wire:model.lazy="total_distance" 
                    class="w-full px-3 pfy-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Contoh: 5000"
                    min="0"
                    step="1">
                @error('total_distance') 
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <x-button type="button" wire:click="$dispatch('close-modal', { name: 'add-truck' })" style="gray">
                    Batal
                </x-button>
                <button type="submit" style="primary" class="px-4 py-2 text-white bg-[var(--color-primary)] rounded-lg hover:opcatiy-90">
                    <span>
                        Simpan
                    </span>
                </button>
            </div>
        </form>
    </x-modal>
 </div>
 