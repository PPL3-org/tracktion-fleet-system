<div>
    <section class="-mt-10">
        <div class="px-4">
            <!-- Start coding here -->
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 mb-2 bg-gray-50 border-b border-gray-200">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
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
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">Nomor Kontak</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($drivers as $driver)
                                <tr class="hover:bg-gray-50 text-center text-xs text-black">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $driver->name }}</td>
                                    <td class="px-4 py-3">{{ $driver->contact_number }}</td>
                                    <td class="px-4 py-3">{{ $driver->email }}</td>
                                    <td class="flex justify-around">
                                        <!-- Tombol Edit -->
                                        <button wire:click="dispatch('editDriver', { id: {{ $driver->id }} })"
                                            class="text-white bg-[#FFB700] rounded-lg p-2 my-2 hover:brightness-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button wire:click="dispatch('confirmDelete', { id: {{ $driver->id }} })"
                                            class="text-white bg-[#C30010] rounded-lg p-2 my-2 hover:brightness-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Dropdown jumlah item per halaman -->
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

                <!-- Pagination -->
                <div class="my-2 px-4">
                    {{ $drivers->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </section>
</div>
