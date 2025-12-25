<x-guest-layout>
    <div class="flex flex-col justify-between min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
        <div class="text-sm sm:text-base flex flex-row items-center">
            <x-heroicon-o-pencil class="w-4 h-4 mr-2" /> Phsar Khmer
        </div>
        <div class="w-full max-w-md mx-auto mt-5">
            <div class="text-center sm:text-left">
                <p class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight"> Welcome Supplier</p>
                <p class="py-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Hey! welcome back to phsar khmer
                </p>
            </div>

        </div>

        @include('auth.partials.tab', ['isSupplier' => true])

        <form method="POST" action="{{ route('register') }}">
            @csrf
            @method('POST')


            <!-- first name -->
            <div class="mt-4">
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                    :value="old('first_name')" required autofocus autocomplete="first_name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            {{-- last name --}}
            <div class="mt-4">
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                    required autofocus autocomplete="last_name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Role -->
            <input type="hidden" name="request_role" value={{ App\Enums\UserRole::SUPPLIER }}>

            <div class="pt-3">
                <x-primary-button class="w-full justify-center">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
            <div class="divider">Or</div>
            <a href="{{ route('google.login', ['request_role' => App\Enums\UserRole::SHOPOWNER]) }}"
                class="btn w-full bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
                Continue with Google
            </a>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>




        <!-- Footer - only visible on larger screens -->
        <div class="hidden sm:block text-center text-xs text-gray-500 dark:text-gray-400">
            © 2025 Phsar Khmer. All rights reserved.
        </div>
    </div>


</x-guest-layout>
