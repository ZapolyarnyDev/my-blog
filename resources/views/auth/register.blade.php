<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
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

        <div
            class="mt-4"
            x-data="{
                fileName: '',
                previewUrl: null,
                clientError: '',
                maxAvatarBytes: 2 * 1024 * 1024,
                updateAvatar(event) {
                    const file = event.target.files[0] || null;

                    if (this.previewUrl) {
                        URL.revokeObjectURL(this.previewUrl);
                    }

                    if (!file) {
                        this.fileName = '';
                        this.previewUrl = null;
                        this.clientError = '';
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

                    if (!allowedTypes.includes(file.type)) {
                        event.target.value = '';
                        this.fileName = '';
                        this.previewUrl = null;
                        this.clientError = {{ \Illuminate\Support\Js::from(__('Only JPG, PNG or WEBP images are allowed.')) }};
                        return;
                    }

                    if (file.size > this.maxAvatarBytes) {
                        event.target.value = '';
                        this.fileName = '';
                        this.previewUrl = null;
                        this.clientError = {{ \Illuminate\Support\Js::from(__('Avatar must be 2MB or less.')) }};
                        return;
                    }

                    this.clientError = '';
                    this.fileName = file ? file.name : '';
                    this.previewUrl = file ? URL.createObjectURL(file) : null;
                }
            }"
        >
            <x-input-label for="avatar" :value="__('Avatar (optional, max 2MB)')" />
            <input
                id="avatar"
                name="avatar"
                type="file"
                accept="image/*"
                class="sr-only"
                @change="updateAvatar($event)"
            />

            <label
                for="avatar"
                class="mt-2 flex cursor-pointer items-center gap-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-4 transition hover:border-indigo-500 hover:bg-indigo-50/30 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-indigo-400 dark:hover:bg-indigo-950/30"
            >
                <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <img x-show="previewUrl" :src="previewUrl" alt="Avatar preview" class="h-full w-full object-cover">
                    <svg x-show="!previewUrl" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21a8 8 0 1 0-16 0"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span>

                <span class="min-w-0">
                    <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Choose avatar') }}
                    </span>
                    <span class="block truncate text-xs text-gray-500 dark:text-gray-400" x-text="fileName || {{ \Illuminate\Support\Js::from(__('PNG, JPG or WEBP up to 2MB')) }}"></span>
                </span>
            </label>

            <p x-show="clientError" x-text="clientError" class="mt-2 text-sm text-red-600 dark:text-red-400"></p>
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
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
