<x-auth-card>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}" wire:submit.prevent="submit">
        @csrf

        <!-- Name -->
        <div class="form-control mb-4">
          <label for="name" class="label">
            <span class="label-text">{{ __('Name') }}</span>
          </label>
          <input id="name" type="text" class="input input-primary input-bordered" name="name" wire:model.defer="name" value="{{ old('name') }}" required autofocus >
        </div>

        <!-- Email Address -->
        <div class="form-control mb-4">
          <label for="email" class="label">
            <span class="label-text">{{ __('Email') }}</span>
          </label>
          <input id="email" type="email" class="input input-primary input-bordered" name="email" wire:model.defer="email" value="{{ old('email') }}" required autofocus >
        </div>

        <!-- Password -->
        <div class="form-control mb-4">
          <label for="password" class="label">
            <span class="label-text">{{ __('Password') }}</span>
          </label>
          <input id="password" type="password" class="input input-primary input-bordered" name="password" wire:model.defer="password" required autocomplete="new-password" >
        </div>

        <!-- Confirm Password -->
        <div class="form-control mb-4">
          <label for="password_confirmation" class="label">
            <span class="label-text">{{ __('Confirm Password') }}</span>
          </label>
          <input id="password_confirmation" type="password" class="input input-primary input-bordered" name="password_confirmation" wire:model.defer="password_confirmation" required >
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button class="btn ml-3">
                <div wire:loading>
                    loading
                </div>
                <div wire:loading.remove>
                    {{ __('Register') }}
                </div>
            </button>
        </div>
    </form>
</x-auth-card>
