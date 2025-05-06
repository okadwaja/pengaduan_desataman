<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- No Telepon -->
        <div class="mt-4">
            <x-input-label for="no_telp" :value="__('No. Telepon')" />
            <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" required />
            <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div class="mt-4">
            <x-input-label for="alamat" :value="__('Alamat (Banjar)')" />
            <select name="alamat" id="alamat" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">-- Pilih Banjar --</option>
                <option value="Br. Batubayan" {{ old('alamat') == 'Br. Batubayan' ? 'selected' : '' }}>Br. Batubayan</option>
                <option value="Br. Dlodpasar" {{ old('alamat') == 'Br. Dlodpasar' ? 'selected' : '' }}>Br. Dlodpasar</option>
                <option value="Br. Gunung" {{ old('alamat') == 'Br. Gunung' ? 'selected' : '' }}>Br. Gunung</option>
                <option value="Br. Jempeng" {{ old('alamat') == 'Br. Jempeng' ? 'selected' : '' }}>Br. Jempeng</option>
                <option value="Br. Jempeng Kauh" {{ old('alamat') == 'Br. Jempeng Kauh' ? 'selected' : '' }}>Br. Jempeng Kauh</option>
                <option value="Br. Ketogan" {{ old('alamat') == 'Br. Ketogan' ? 'selected' : '' }}>Br. Ketogan</option>
                <option value="Br. Mambul" {{ old('alamat') == 'Br. Mambul' ? 'selected' : '' }}>Br. Mambul</option>
                <option value="Br. Pegongan" {{ old('alamat') == 'Br. Pegongan' ? 'selected' : '' }}>Br. Pegongan</option>
                <option value="Br. Raketan" {{ old('alamat') == 'Br. Raketan' ? 'selected' : '' }}>Br. Raketan</option>
                <option value="Br. Sukajati" {{ old('alamat') == 'Br. Sukajati' ? 'selected' : '' }}>Br. Sukajati</option>
                <option value="Br. Tabah" {{ old('alamat') == 'Br. Tabah' ? 'selected' : '' }}>Br. Tabah</option>
                <option value="Br. Tebejero" {{ old('alamat') == 'Br. Tebejero' ? 'selected' : '' }}>Br. Tebejero</option>
            </select>
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
