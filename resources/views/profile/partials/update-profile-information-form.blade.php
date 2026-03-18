<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div
            x-data="{
                fileName: '',
                previewUrl: {{ \Illuminate\Support\Js::from($user->avatar_path ? asset('storage/' . $user->avatar_path) : null) }},
                clientError: '',
                hintText: {{ \Illuminate\Support\Js::from(__('PNG, JPG or WEBP up to 2MB')) }},
                invalidTypeText: {{ \Illuminate\Support\Js::from(__('Only JPG, PNG or WEBP images are allowed.')) }},
                invalidSizeText: {{ \Illuminate\Support\Js::from(__('Avatar must be 2MB or less.')) }},
                maxAvatarBytes: 2 * 1024 * 1024,
                updateAvatar(event) {
                    const file = event.target.files[0] || null;

                    if (this.previewUrl && this.previewUrl.startsWith('blob:')) {
                        URL.revokeObjectURL(this.previewUrl);
                    }

                    if (!file) {
                        this.fileName = '';
                        this.clientError = '';
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

                    if (!allowedTypes.includes(file.type)) {
                        event.target.value = '';
                        this.fileName = '';
                        this.clientError = this.invalidTypeText;
                        return;
                    }

                    if (file.size > this.maxAvatarBytes) {
                        event.target.value = '';
                        this.fileName = '';
                        this.clientError = this.invalidSizeText;
                        return;
                    }

                    this.clientError = '';
                    this.fileName = file.name;
                    this.previewUrl = URL.createObjectURL(file);
                }
            }"
        >
            <x-input-label for="avatar" :value="__('Avatar (max 2MB)')" />

            <div class="mt-2 flex items-center gap-4">
                <div class="h-20 w-20 overflow-hidden rounded-full bg-gray-100 ring-2 ring-gray-200 dark:bg-gray-700 dark:ring-gray-600">
                    <img x-show="previewUrl" :src="previewUrl" alt="{{ $user->name }}" class="h-full w-full object-cover">
                    <div x-show="!previewUrl" class="flex h-full w-full items-center justify-center text-sm font-semibold text-gray-500 dark:text-gray-300">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                </div>

                <div class="flex-1">
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
                        class="flex cursor-pointer items-center gap-3 rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-3 transition hover:border-indigo-500 hover:bg-indigo-50/30 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-indigo-400 dark:hover:bg-indigo-950/30"
                    >
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 21a8 8 0 1 0-16 0"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Choose new avatar') }}</span>
                            <span class="block truncate text-xs text-gray-500 dark:text-gray-400" x-text="fileName || hintText"></span>
                        </span>
                    </label>
                </div>
            </div>

            <p x-show="clientError" x-text="clientError" class="mt-2 text-sm text-red-600 dark:text-red-400"></p>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
