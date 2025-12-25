<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col justify-between min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
        <div class="text-sm sm:text-base flex flex-row items-center">
            <x-heroicon-o-pencil class="w-4 h-4 mr-2" /> Phsar Khmer
        </div>
        <div class="w-full max-w-md mx-auto space-y-6 sm:space-y-8">
            <div class="text-center sm:text-left">
                <p class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight"> Welcome Back</p>
                <p class="py-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Hey! welcome back to phsar khmer
                </p>
            </div>

            {{-- <a href="{{ route('google.login', ['request_role' => App\Enums\UserRole::SHOPOWNER]) }}"
                class="btn w-full bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
                Continue with Google
            </a>

            <a href="{{ route('facebook.login', ['role' => 'supplier']) }}"
                class="btn w-full bg-[#1877F2] text-white border-none hover:bg-[#165CD7]">
                <i class="fab fa-facebook-f mr-2"></i>
                Continue with Facebook
            </a> --}}

            <div class="divider">Or</div>


            <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('register') }}">
                        {{ __('Don\'t have Account Yet?') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer - only visible on larger screens -->
        <div class="hidden sm:block text-center text-xs text-gray-500 dark:text-gray-400">
            © 2025 Phsar Khmer. All rights reserved.
        </div>
    </div>
</x-guest-layout>
