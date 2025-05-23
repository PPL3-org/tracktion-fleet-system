<x-auth.auth-form>
    <x-slot:title>
        Login
    </x-slot:title>
    <div class="w-full max-w-sm">
        <form action="/login" method="POST" class="bg-white shadow-md rounded px-6 pt-5 pb-6">
            <h1 class="text-2xl text-[#170F49] text-center font-bold">
                Selamat Datang!
            </h1>
            <p class="text-sm text-center text-[#64748B] mt-2 mb-4">
                Masuk ke akun anda untuk melanjutkan aktivitas dengan mudah dan aman
            </p>
            @csrf
            <x-auth.form-field label="Email" name="email" type="email" placeholder="Masukan email anda" class="text-sm" />
            <x-auth.form-field label="Password" name="password" type="password" placeholder="Masukan password anda" class="text-sm" />
            <div class="flex justify-end mb-3">
                <a href="#" class="text-xs text-[#9747FF] font-semibold hover:underline">Lupa password?</a>
            </div>

            <x-auth.form-error field="credentials"/>

            <x-auth.form-button value="LOG IN" class="text-sm"></x-form-button>

            <div class="flex justify-center mt-3">
                <span class="text-xs text-gray-700 font-semibold">
                    Belum memiliki akun? <a href="{{ route('register') }}" class="text-xs text-[#9747FF] hover:underline">Register</a>
                </span>
            </div>
        </form>
    </div> 
</x-auth.auth-form>