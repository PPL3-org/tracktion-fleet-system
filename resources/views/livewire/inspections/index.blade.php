<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">
     
    <x-page-menu>
     <div>
         <span class="text-2xl text-white font-sans font-semibold">Data Inspeksi Kendaraan</span>
     </div>

     <div class="flex justify-around gap-3.5">
        <x-button wire:click="addInspectionSchedule" style='white' >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>  
            Jadwal Inspeksi
        </x-button>
      </div>
  </x-page-menu>

  <livewire:inspections.table lazy />

 </div>
