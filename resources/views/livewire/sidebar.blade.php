<div x-data="{ open: false }" class="relative z-50">

<aside 
    x-on:toggle.window = "open = ! open"
    class="bg-white h-full fixed inset-y-0 left-0 flex flex-col justify-between transition-all duration-300 overflow-hidden shadow-md"
    x-bind:class="open ? 'w-1/6 mr-[18%]' : 'w-0 mr-0'"
    >
    <div class="p-4">
        <div class="flex items-center gap-2 mb-9">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10">
            <h2 class="text-2xl font-sans text-black font-semibold">Tracktion</h2>
        </div>
        <div class="flex justify-between">
            <span class="text-[#004BA4] text-sm font-semibold font-sans">MENU</span>
            <button @click="$dispatch('toggle')"
                    class="p-2 rounded-md transition-all duration-200 hover:bg-gray-200 z-50">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.92 1.42L8.5 0L4.96 3.55L1.42 0L0 1.42L3.55 4.96L0 8.5L1.42 9.92L4.96 6.37L8.5 9.92L9.92 8.5L6.37 4.96L9.92 1.42Z" 
                          fill="#1C2E45" fill-opacity="0.6"/>
                </svg>
            </button>
        </div>
    
        <nav class="flex flex-col gap-3 mt-4">
            <x-nav-link href="{{ route('shipments.index') }}" :active="request()->is('shipments')">
                <svg class="w-4 h-4 text-current group-hover:text-white" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.5 0C1.96957 0 1.46086 0.210714 1.08579 0.585786C0.710714 0.960859 0.5 1.46957 0.5 2V4C0.5 4.53043 0.710714 5.03914 1.08579 5.41421C1.46086 5.78929 1.96957 6 2.5 6H4.5C5.03043 6 5.53914 5.78929 5.91421 5.41421C6.28929 5.03914 6.5 4.53043 6.5 4V2C6.5 1.46957 6.28929 0.960859 5.91421 0.585786C5.53914 0.210714 5.03043 0 4.5 0H2.5ZM2.5 8C1.96957 8 1.46086 8.21071 1.08579 8.58579C0.710714 8.96086 0.5 9.46957 0.5 10V12C0.5 12.5304 0.710714 13.0391 1.08579 13.4142C1.46086 13.7893 1.96957 14 2.5 14H4.5C5.03043 14 5.53914 13.7893 5.91421 13.4142C6.28929 13.0391 6.5 12.5304 6.5 12V10C6.5 9.46957 6.28929 8.96086 5.91421 8.58579C5.53914 8.21071 5.03043 8 4.5 8H2.5ZM8.5 2C8.5 1.46957 8.71071 0.960859 9.08579 0.585786C9.46086 0.210714 9.96957 0 10.5 0H12.5C13.0304 0 13.5391 0.210714 13.9142 0.585786C14.2893 0.960859 14.5 1.46957 14.5 2V4C14.5 4.53043 14.2893 5.03914 13.9142 5.41421C13.5391 5.78929 13.0304 6 12.5 6H10.5C9.96957 6 9.46086 5.78929 9.08579 5.41421C8.71071 5.03914 8.5 4.53043 8.5 4V2ZM8.5 10C8.5 9.46957 8.71071 8.96086 9.08579 8.58579C9.46086 8.21071 9.96957 8 10.5 8H12.5C13.0304 8 13.5391 8.21071 13.9142 8.58579C14.2893 8.96086 14.5 9.46957 14.5 10V12C14.5 12.5304 14.2893 13.0391 13.9142 13.4142C13.5391 13.7893 13.0304 14 12.5 14H10.5C9.96957 14 9.46086 13.7893 9.08579 13.4142C8.71071 13.0391 8.5 12.5304 8.5 12V10Z" fill="currentColor"/>
                </svg>
                Pengiriman
            </x-nav-link>

            <x-nav-link href="{{ route('trucks.index') }}" :active="request()->is('trucks')">
                <svg class="w-4 h-4 text-current group-hover:text-white" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.79 11.3373H6.72667C6.45083 12.544 5.39167 13.4582 4.10333 13.4582C2.81583 13.4582 1.75667 12.544 1.48 11.3365H1C0.83424 11.3365 0.675268 11.2707 0.558058 11.1534C0.440848 11.0362 0.375 10.8773 0.375 10.7115V1.99984C0.375 1.19484 1.02833 0.541504 1.83333 0.541504H9.99417C10.8 0.541504 11.4525 1.19484 11.4525 1.99984V3.19317H12.7108C13.3292 3.19317 13.9208 3.44234 14.3525 3.88484L16.4475 6.03317C16.5614 6.14998 16.6251 6.30669 16.625 6.46984V10.7115C16.6253 10.871 16.5646 11.0245 16.4554 11.1407C16.3462 11.2569 16.1967 11.3269 16.0375 11.3365C15.7617 12.5432 14.7017 13.4582 13.4142 13.4582C12.1267 13.4582 11.0667 12.5448 10.79 11.3373ZM4.10333 9.21484C3.32 9.21484 2.65917 9.86984 2.65917 10.7107C2.65917 11.5523 3.32083 12.2073 4.10333 12.2073C4.88583 12.2073 5.5475 11.5523 5.5475 10.7107C5.5475 9.86984 4.88667 9.21484 4.10333 9.21484ZM13.4142 9.21484C12.6308 9.21484 11.97 9.86984 11.97 10.7107C11.97 11.5523 12.6308 12.2073 13.4142 12.2073C14.1967 12.2073 14.8575 11.5523 14.8575 10.7107C14.8575 9.86984 14.1967 9.21484 13.4142 9.21484Z" fill="currentColor"/>
                </svg>
                Truk
            </x-nav-link>

            <x-nav-link href="{{ route('drivers.index') }}" :active="request()->is('drivers')">
                <svg class="w-4 h-4 text-current group-hover:text-white" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.9 0C1.3 0 4 7.3 4 7.3C4.6 8.3 5.4 8.1 5.4 8.8C5.4 9.4 4.7 9.6 4 9.7C2.9 9.7 1.9 9.5 0.9 11.3C0.3 12.4 0 16 0 16H13.7C13.7 16 13.4 12.4 12.9 11.3C11.9 9.4 10.9 9.7 9.8 9.6C9.1 9.5 8.4 9.3 8.4 8.7C8.4 8.1 9.2 8.3 9.8 7.2C9.8 7.3 12.5 0 6.9 0V0Z" fill="currentColor"/>
                </svg>
                Pengemudi
            </x-nav-link>

            <x-nav-link href="{{ route('reports.index') }}" :active="request()->is('reports')">
                <svg class="w-4 h-4 text-current group-hover:text-white" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.5 2C0.5 1.46957 0.710714 0.960859 1.08579 0.585786C1.46086 0.210714 1.96957 0 2.5 0C2.5 0.795649 2.81607 1.55871 3.37868 2.12132C3.94129 2.68393 4.70435 3 5.5 3H7.5C8.29565 3 9.05871 2.68393 9.62132 2.12132C10.1839 1.55871 10.5 0.795649 10.5 0C11.0304 0 11.5391 0.210714 11.9142 0.585786C12.2893 0.960859 12.5 1.46957 12.5 2V8H7.914L9.207 6.707C9.38916 6.5184 9.48995 6.2658 9.48767 6.0036C9.4854 5.7414 9.38023 5.49059 9.19482 5.30518C9.00941 5.11977 8.7586 5.0146 8.4964 5.01233C8.2342 5.01005 7.9816 5.11084 7.793 5.293L4.793 8.293C4.60553 8.48053 4.50021 8.73484 4.50021 9C4.50021 9.26516 4.60553 9.51947 4.793 9.707L7.793 12.707C7.9816 12.8892 8.2342 12.99 8.4964 12.9877C8.7586 12.9854 9.00941 12.8802 9.19482 12.6948C9.38023 12.5094 9.4854 12.2586 9.48767 11.9964C9.48995 11.7342 9.38916 11.4816 9.207 11.293L7.914 10H12.5V13C12.5 13.5304 12.2893 14.0391 11.9142 14.4142C11.5391 14.7893 11.0304 15 10.5 15H2.5C1.96957 15 1.46086 14.7893 1.08579 14.4142C0.710714 14.0391 0.5 13.5304 0.5 13V2ZM12.5 8H14.5C14.7652 8 15.0196 8.10536 15.2071 8.29289C15.3946 8.48043 15.5 8.73478 15.5 9C15.5 9.26522 15.3946 9.51957 15.2071 9.70711C15.0196 9.89464 14.7652 10 14.5 10H12.5V8Z" fill="currentColor"/>
                </svg>
                Laporan
            </x-nav-link>
            
            <x-nav-link href="{{ route('inspections.index') }}" :active="request()->is('reports')">
                <svg class="w-6 h-6 text-current group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m20 8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z"/>
                </svg>
                Inspeksi Kendaraan
            </x-nav-link>

            {{-- 👇 PENAMBAHAN MENU MANAJEMEN ADMIN 👇 --}}
            <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index') || request()->is('admin/users*')">
                <svg class="w-4 h-4 text-current group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Manajemen Admin
            </x-nav-link>
            {{-- 👆 AKHIR PENAMBAHAN MENU MANAJEMEN ADMIN 👆 --}}
            
        </nav>
    </div>

    <form action="/logout" method="POST" class="mt-auto p-4">
        @csrf
        <button type="submit" class="group flex items-center gap-2 w-full bg-white text-sm font-sans text-red-600 p-2 rounded mt-4 hover:bg-red-600 hover:text-white transition">
            <svg class="w-5 h-5 stroke-red-600 group-hover:stroke-white" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 13L5 9M5 9L9 5M5 9H19M14 13V14C14 14.7956 13.6839 15.5587 13.1213 16.1213C12.5587 16.6839 11.7956 17 11 17H4C3.20435 17 2.44129 16.6839 1.87868 16.1213C1.31607 15.5587 1 14.7956 1 14V4C1 3.20435 1.31607 2.44129 1.87868 1.87868C2.44129 1.31607 3.20435 1 4 1H11C11.7956 1 12.5587 1.31607 13.1213 1.87868C13.6839 2.44129 14 3.20435 14 4V5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Keluar
        </button>
    </form>
    </aside>

</div>