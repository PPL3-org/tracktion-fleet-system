<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'md:ml-[20%] md:w-[80%]' : 'ml-0'">
     
    <x-page-menu>
        <div>
            <span class="text-2xl text-white font-sans font-semibold">Laporan Kendala</span>
        </div>

        <x-button wire:click='exportExcel' style='green'>Cetak .xlsx</x-button>
     </x-page-menu>

     <livewire:reports.table lazy />
 </div>