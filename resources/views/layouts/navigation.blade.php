<div class="navbar mb-0 md:mb-2 shadow-lg bg-neutral text-neutral-content">
  <div class="flex-none px-2">
    <button class="btn btn-square btn-ghost flex md:hidden" id="btnOpen">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </div>
  <div class="flex-none px-2 mx-2">
    <span class="text-lg font-bold">{{ config('app.name') }}</span>
  </div>

  <div class="flex-1 px-2 mx-2">
    <div class="items-stretch hidden md:flex">
      <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('home') }}">
              Home
            </a>
      <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('about') }}">
              About
            </a>
      <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('contact') }}">
              Contact
            </a>
            @auth
      <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('myplaces') }}">
              My Places
            </a>
            @endauth
    </div>
  </div>

  @auth
    {{-- profile --}}
    <div class="flex-none">
      <a class="btn btn-square btn-ghost" href="{{ route('profile.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      </a>
    </div>
    {{-- log out --}}
    <div class="flex-none">
      <a class="btn btn-square btn-ghost" href="{{ route('logout') }}" onclick="event.preventDefault(); this.nextElementSibling.submit();">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf @method('POST')
      </form>
    </div>
  @else
    {{-- Register --}}
    <div class="flex-none">
      <a class="btn btn-square btn-ghost" href="{{ route('register') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
      </a>
    </div>
    {{-- Login --}}
    <div class="flex-none">
      <a class="btn btn-square btn-ghost" href="{{ route('login') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
        </svg>
      </a>
    </div>
  @endauth
</div>
<div class="flex-col justify-between items-stretch hidden flex md:hidden p-2 w-full mb-2 shadow-lg bg-neutral text-neutral-content" id="nav">
  <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('home') }}">
          Home
        </a>
  <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('about') }}">
          About
        </a>
  <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('contact') }}">
          Contact
        </a>
            @auth
      <a class="btn btn-ghost btn-sm rounded-btn" href="{{ route('myplaces') }}">
              My Places
            </a>
            @endauth
</div>