@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4">
        @if(isset($invalid))
            <div class="alert alert-error">
              <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
                <label>{{ $invalid }}</label>
              </div>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a href="{{ route('home') }}" class="btn">Go back</a>
            </div>
        @endif

        @if (isset($path))
            <div class="flex items-center justify-center h-40">
                <a href="#" class="btn btn-lg flex items-center justify-center flex-col">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </a>
            </div>
        @endif
    </div>
@endsection