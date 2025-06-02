<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">
     
    <x-page-menu>
     <div>
         <span class="text-2xl text-white font-sans font-semibold">Jadwal Inspeksi Kendaraan</span>
     </div>

     <div class="flex justify-around gap-3.5">
        <x-button wire:click="createInspectionSchedule" style='white' >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>  
            Buat jadwal
        </x-button>
      </div>
  </x-page-menu>

  <div>
    <section class="-mt-10">
        <div class="px-4">
            <!-- Start coding here -->
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 mb-2 bg-gray-50 border-b border-gray-200">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms='search' type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 placeholder-gray-400"
                            placeholder="Search">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-[#667085] font-medium bg-gray-100">
                            <tr class="text-center">
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Nomor Plat</th>
                                <th scope="col" class="px-4 py-3">Tanggal Inspeksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($schedules as $schedule)
                            <tr wire:key="{{ $schedule->id }}" class="hover:bg-gray-50 text-center text-xs text-black">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $schedule->truck->plate_number }}</td>
                                <td class="px-4 py-3">{{ $schedule->formatted_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-4">
                    <div class="flex items-center">
                        <label class="text-xs font-medium text-gray-900 mr-2">Per Page</label>
                        <select wire:model.live='itemsPerPage'
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>

                <div class="my-2 px-4">
                    {{ $schedules->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </section>
</div>

<x-modal title="Buat Jadwal Inspeksi" name="create-inspection-schedule">
    <form wire:submit="save" class="space-y-4">
        <div>
            <label for="plate_number" class="block text-sm font-medium text-gray-700">Nomor Plat</label>
            <div class="mt-1 relative">
                <input
                    type="text"
                    wire:model="plate_number"
                    id="plate_number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="Masukkan nomor plat"
                >
                @error('plate_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="inspection_date" class="block text-sm font-medium text-gray-700">Tanggal Inspeksi</label>
            <div class="mt-1">
                <input
                    type="datetime-local"
                    wire:model="inspection_date"
                    id="inspection_date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                @error('inspection_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-5 flex justify-end gap-x-3">
            <x-button type="button" x-on:click="$dispatch('close-modal', 'create-inspection-schedule')" style="white">
                Batal
            </x-button>
            <x-button type="submit" style="dark">
                Simpan
            </x-button>
        </div>
    </form>
</x-modal>

 </div>
