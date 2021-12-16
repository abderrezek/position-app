<x-auth-card>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}" wire:submit.prevent="submit" >
        @csrf

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
          <input id="password" type="password" class="input input-primary input-bordered" name="password" wire:model.defer="password" required autocomplete="current-password" >
        </div>

        <!-- Remember Me -->
          <div class="form-control">
            <label for="remember_me" class="cursor-pointer flex items-center py-2 px-1">
              <input id="remember_me" type="checkbox" class="checkbox checkbox-sm mr-2" wire:model.defer="remember" name="remember">
              <span class="label-text">{{ __('Remember me') }}</span>
            </label>
          </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button class="btn ml-3">
                <div wire:loading>
                    loading
                </div>
                <div wire:loading.remove>
                    {{ __('Log in') }}
                </div>
            </button>
        </div>
        <div class="flex items-center justify-center mt-4 space-x-2">
            <a target="_blank" href="{{ route("socialite.redirect", ["provider" => "google"]) }}" class="btn btn-sm btn-outline">
                Google
            </a>
            <a target="_blank" href="{{ route("socialite.redirect", ["provider" => "facebook"]) }}" class="btn btn-sm btn-outline">
                Facebook
            </a>
        </div>
    </form>
</x-auth-card>