@extends('layouts.main')

@section('content')

<div class="container mx-auto p-2">
    <h1 class="text-center font-bold text-4xl uppercase my-3">my places</h1>

    @if (session('faild'))
        <div class="alert alert-error">
          <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
            <label>{{ session('faild') }}</label>
          </div>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
          <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>
            <label>{{ session('success') }}</label>
          </div>
        </div>
    @endif
@if(!$places->isEmpty())
    <div class="flex justify-end mb-2">
        <a href="#ask-delete-all" class="btn btn-warning btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            Supprimer tous
        </a>
    </div>
    {{-- model delete all --}}
    <div id="ask-delete-all" class="modal">
      <div class="modal-box">
        <p>Are you sure for delete all placeds ?</p>
        <div class="modal-action">
            <form action="{{ route('myplaces.destroyAll') }}" method="POST">
                @csrf
                @method('POST')

                <button type="submit" class="btn btn-warning">Yes</button>
            </form>
            <a href="#" class="btn">No</a>
        </div>
      </div>
    </div>
    {{-- placeds --}}
    <table class="table w-full table-zebra mb-2">
        <thead>
            <tr>
                <th class="font-bold text-md">#</th>
                <th class="font-bold text-md">Message</th>
                <th class="font-bold text-md">Time</th>
                <th class="font-bold text-md">Site web</th>
                <th class="font-bold text-md">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($places as $place)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $place->message }}</td>
                    <td>{{ $place->time }}</td>
                    <td>{{ $place->url }}</td>
                    <td>
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" class="btn btn-ghost btn-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <ul tabindex="0" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52">
                                <li>
                                    <a href="#ask-d-{{ $place->uuid }}">Delete</a>
                                </li>
                                <li>
                                    <a href="{{ route('myplaces.update', ['placed' => $place]) }}">Update</a>
                                </li>
                                <li>
                                    <a href="{{ route('export', ['uuid' => $place->uuid, 'type' => 'svg', 'size' => 'sm']) }}">
                                        Download SVG
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('export', ['uuid' => $place->uuid, 'type' => 'png', 'size' => 'sm']) }}">
                                        Download PNG
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                {{-- model delete all --}}
                <div id="ask-d-{{ $place->uuid }}" class="modal">
                  <div class="modal-box">
                    <p>Are you sure for delete cette place {{ $place->id }} ?</p>
                    <div class="modal-action">
                        <form action="{{ route('myplaces.destroy', ['placed' => $place]) }}" method="POST">
                            @csrf
                            @method('POST')

                            <button type="submit" class="btn btn-warning">Yes</button>
                        </form>
                        <a href="#" class="btn">No</a>
                    </div>
                  </div>
                </div>
            @endforeach
        </tbody>
      </table>
      {{ $places->links() }}
@else
    <div class="flex items-center justify-center my-6">
        <a class="btn" href="{{ route('home') }}">Go and create placed</a>
    </div>
@endif
</div>

@endsection