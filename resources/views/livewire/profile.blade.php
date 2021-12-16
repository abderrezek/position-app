<div class="w-full md:w-1/2 mx-auto">
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    {{-- success save --}}
    @if ($success)
        <div class="alert alert-success">
          <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
            <label>success update profile</label>
          </div>
        </div>
    @endif

    <form class="space-y-2" action="{{ route('profile.index') }}" method="post" wire:submit.prevent="submit">
        @csrf

        {{-- name --}}
        <div class="form-control">
          <label class="label">
            <span class="label-text">Name</span>
          </label>
          <input type="text" class="input input-bordered" name="name" wire:model.defer="name">
        </div>
        {{-- email --}}
        <div class="form-control">
          <label class="label">
            <span class="label-text">E-mail</span>
          </label>
          <input type="email" class="input input-bordered" name="email" wire:model.defer="email">
        </div>
        {{-- password --}}
        <div class="form-control">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input type="password" class="input input-bordered" name="password" wire:model.defer="password">
        </div>
        {{-- password confirmation --}}
        <div class="form-control">
          <label class="label">
            <span class="label-text">Password Confirmation</span>
          </label>
          <input type="password" class="input input-bordered" name="password_confirmation" wire:model.defer="password_confirmation">
        </div>

        <button type="submit" class="btn btn-block">Update</button>
    </form>
</div>
