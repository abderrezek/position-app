<div>
@if (session()->has('sended') && session('sended'))
    <div class="flex items-center justify-center my-3">
        <div class="flex items-center flex-col">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-green-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p>Sended E-mail success</p>
        </div>
    </div>
@else
    @if ($errors->any())
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form class="space-y-2" method="POST" action="{{ route('contact') }}" wire:submit.prevent="submit" novalidate>
        @csrf

        {{-- name --}}
        <div class="form-control">
          <label for="name" class="label">
            <span class="label-text">Name</span>
          </label>
          <input id="name" type="text" class="input input-bordered" name="name" wire:model.defer="name" required>
        </div>

        {{-- Email --}}
        <div class="form-control">
          <label for="email" class="label">
            <span class="label-text">E-mail</span>
          </label>
          <input id="email" type="email" class="input input-bordered" name="email" wire:model.defer="email" required>
        </div>

        {{-- Message --}}
        <div class="form-control">
          <label for="message" class="label">
            <span class="label-text">Message</span>
          </label>
          <textarea id="message" class="textarea h-24 textarea-bordered" name="message" wire:model.defer="message" required></textarea>
        </div>

        <button class="btn btn-block" wire:loading.class="loading">
            Send
        </button>
    </form>
@endif
</div>