<div>
    <section class="-mt-10">
        <div class="px-4">
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <!-- Search and Date Filter Section -->
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between p-4 mb-2 bg-gray-50 border-b border-gray-200 space-y-4 md:space-y-0">
                    <div class="w-full md:w-64 relative">
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

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-medium text-gray-600">Start Date</label>
                            <input wire:model.live='startDate' type="date"
                                class="text-xs border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-medium text-gray-600">End Date</label>
                            <input wire:model.live='endDate' type="date"
                                class="text-xs border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-[#667085] font-medium bg-gray-100">
                            <tr class="text-center">
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Nomor Plat</th>
                                <th scope="col" class="px-4 py-3">Lokasi</th>
                                <th scope="col" class="px-4 py-3">Tipe Kendala</th>
                                <th scope="col" class="px-4 py-3">Deskripsi Laporan</th>
                                <th scope="col" class="px-4 py-3">Tanggal Laporan</th>
                                <th scope="col" class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($reports as $report)
                            <tr wire:click="viewReport({{ $report->id }})" wire:key="{{ $report->id }}"
                                class="hover:bg-gray-50 text-center text-xs text-black cursor-pointer">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $report->plate_number }}</td>
                                <td class="px-4 py-3 text-left whitespace-normal break-words">{{
                                    $report->report_location }}</td>
                                <td class="px-4 py-3">{{ ucwords($report->problem_type) }}</td>
                                <td class="px-4 py-3 text-left whitespace-normal break-words">{{
                                    ucfirst($report->problem_description) }}</td>
                                <td class="px-4 py-3">{{ $report->formatted_date }}</td>
                                <td class="flex justify-around">
                                    <button wire:click.stop="viewEditReport('{{ $report->id }}')"
                                        class="text-white bg-[#FFB700] rounded-lg p-2 my-2 cursor-pointer hover:opacity-90">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden">
                    @foreach ($reports as $report)
                    <div wire:click="viewReport({{ $report->id }})" wire:key="{{ $report->id }}"
                        class="p-4 border-b border-gray-200 hover:bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <div class="text-sm font-medium text-gray-900">{{ $report->plate_number }}
                            </div>
                            <span class="text-xs font-medium text-gray-500">{{ $report->formatted_date }}</span>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tipe Kendala:</span>
                                <span class="font-medium">{{ ucwords($report->problem_type) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block mb-1">Lokasi:</span>
                                <p class="font-medium text-gray-800 whitespace-normal break-words">
                                    {{ ucfirst($report->report_location) }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500 block mb-1">Deskripsi:</span>
                                <p class="font-medium text-gray-800 whitespace-normal break-words">
                                    {{ ucfirst($report->problem_description) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination Controls -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
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
                        <div class="md:ml-auto">
                            {{ $reports->links(data: ['scrollTo' => false]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-modal title="Detail Laporan Kendala" name="detail-view-report">
        @if ($selectedReport)
        <livewire:reports.view :report="$selectedReport" :key="$selectedReport->id">
            @endif
    </x-modal>

    <x-modal title="Ubah data laporan" name="view-edit-report" focusable>
        @if($selectedReport)
        <form wire:submit.prevent="updateReport" class="p-6 space-y-4">
            <!-- Plate Number (disabled) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Plat</label>
                <input type="text" class="w-full mt-1 p-2 border rounded bg-gray-100"
                    value="{{ $selectedReport->plate_number }}" disabled>
            </div>
            <!-- Location (disabled) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" class="w-full mt-1 p-2 border rounded bg-gray-100"
                    value="{{ $selectedReport->report_location }}" disabled>
            </div>
            <!-- Problem Type (editable) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe Kendala</label>
                <select wire:model.defer="problem_type" name="problem_type" class="w-full mt-1 p-2 border rounded">
                    <option value="">Pilih Tipe Kendala</option>
                    <option value="kemacetan">Kemacetan</option>
                    <option value="kecelakaan">Kecelakaan</option>
                    <option value="masalah kendaraan">Masalah Kendaraan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <!-- Problem Description (editable) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi Laporan</label>
                <textarea wire:model.defer="problem_description" name="problem_description"
                    class="w-full mt-1 p-2 border rounded" rows="3"></textarea>
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