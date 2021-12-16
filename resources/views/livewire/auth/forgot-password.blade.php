<x-auth-card>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.email') }}" wire:submit.prevent="submit">
        @csrf

        <!-- Email Address -->
        <div class="form-control mb-4">
          <label for="email" class="label">
            <span class="label-text">{{ __('Email') }}</span>
          </label>
          <input id="email" type="email" class="input input-primary input-bordered" name="email" wire:model.defer="email" value="{{ old('email') }}" required autofocus >
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn ml-3">
                <div wire:loading>
                    loading
                </div>
                <div wire:loading.remove>
                    {{ __('Email Password Reset Link') }}
                </div>
            </button>
        </div>
    </form>
</x-auth-card>