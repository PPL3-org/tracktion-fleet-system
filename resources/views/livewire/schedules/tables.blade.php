<div>
    <section class="-mt-10">
        <div class="px-4">
            <!-- Start coding here -->
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 mb-2 bg-gray-50 border-b border-gray-200">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input 
                        wire:model.live.debounce.300ms = 'search'
                        type="text" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 placeholder-gray-400" 
                        placeholder="Search">
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-medium text-gray-600">Start Date</label>
                            <input wire:model.live='startDate' 
                            type="date" class="text-xs border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-medium text-gray-600">End Date</label>
                            <input wire:model.live='endDate'
                            type="date" class="text-xs border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-[#667085] font-medium bg-gray-100">
                            <tr class="text-center">
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Klien</th>
                                <th scope="col" class="px-4 py-3">Harga Pengiriman</th>
                                <th scope="col" class="px-4 py-3">Tanggal Pengiriman</th>
                                <th scope="col" class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($schedules as $schedule)
                                <tr class="hover:bg-gray-100 text-center text-xs text-black cursor-pointer">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $schedule->client }}</td>
                                    <td class="px-4 py-3">{{ $schedule->delivery_price }}</td>
                                    <td class="px-4 py-3">{{ $schedule->departure_date }}</td>
                                    <td class="flex justify-around">
                                        <button wire:click="viewEditSchedule('{{ $schedule->id }}')" class="text-white bg-[#FFB700] rounded-lg p-2 my-2 cursor-pointer hover:opacity-90">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                    </td>
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

                <div class="my-2 px-4">
                </div>
            </div>
        </div>
    </section>

    <x-modal title="Ubah data jadwal pengiriman" name="view-edit-shipment-schedule" focusable>
        @if($selectedSchedule)
        <form wire:submit.prevent="updateSchedule" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Klien</label>
                <input type="text" wire:model.defer="client" name="client" class="w-full mt-1 p-2 border rounded">
            </div>
            <!-- Problem Description (editable) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga Pengiriman</label>
                <input type="number" wire:model.defer="delivery_price" name="delivery_price" class="w-full mt-1 p-2 border rounded">
            </div>
            <div>
                <label for="departure_date" class="block text-sm font-medium text-gray-700">Tanggal Keberangkatan</label>
                <input
                    type="datetime-local"
                    wire:model.defer="departure_date"
                    id="departure_date"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
            </div>
            @if($errors->any())
            <p class="text-xs text-center text-red-600 my-2 font-medium">{{ $errors->first() }}</p>
            @endif
            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-[var(--color-primary)] text-white hover:opacity-80 rounded-lg cursor-pointer">
                    Simpan
                </button>
            </div>
        </form>
        @endif
    </x-modal>
</div>