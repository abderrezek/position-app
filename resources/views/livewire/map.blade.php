<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Map --}}
        <div class="flex items-center justify-between flex-col">
            <div id="map" class="w-full h-96" wire:ignore></div>

            @if (is_null($qrcode))
            <div class="flex justify-end items-center w-full">
                <button class="btn btn-sm btn-ghost" onclick="remove()" @if ($disabled) disabled="disabled" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            @endif
        </div>

        <div class="space-y-3">
            @if (is_null($qrcode))
                {{-- Message --}}
                <div class="form-control">
                    <label class="label" @if($disabled) disabled="disabled" @endif>
                        <span class="label-text">Message</span>
                    </label>
                    <textarea
                        class="textarea h-24 textarea-bordered @error('message')textarea-error @enderror"
                        wire:model.defer="message"
                        rows="4"
                        @if($disabled) disabled="disabled" @endif
                    ></textarea>
                    @error('message')
                    <label class="label">
                        <span class="label-text-alt text-yellow-700">{{ $message }}</span>
                    </label>
                    @enderror
                </div>

                {{-- time --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Time</span>
                    </label>
                    <div class="flex items-center justify-start space-x-1">
                        {{-- hour --}}
                        <select class="select select-bordered select-sm w-16 @error('hour')select-error @enderror" wire:model.defer="hour" @if($disabled || !$enabledTime) disabled="disabled" @endif>
                          @for ($i = 0; $i < 24; $i++)
                            @php
                                $n = str_pad($i, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <option value="{{ $n }}">{{ $n }}</option>
                          @endfor
                        </select>
                        {{-- minute --}}
                        <select class="select select-bordered select-sm w-16 @error('minute')select-error @enderror" wire:model.defer="minute" @if($disabled || !$enabledTime) disabled="disabled" @endif>
                          @for ($i = 0; $i < 60; $i++)
                            @php
                                $n = str_pad($i, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <option value="{{ $n }}">{{ $n }}</option>
                          @endfor
                        </select>
                        {{-- enable --}}
                        <div class="card bordered">
                          <div class="form-control" @if($disabled) disabled="disabled" @endif>
                            <label class="cursor-pointer label" @if($disabled) disabled="disabled" @endif>
                              <input type="checkbox" checked="checked" class="checkbox checkbox-xs mr-2" @if($disabled) disabled="disabled" @endif wire:model="enabledTime">
                              <span class="label-text" @if($disabled) disabled="disabled" @endif>Use time</span>
                            </label>
                          </div>
                        </div>
                    </div>
                    @error('hour')
                    <label class="label">
                        <span class="label-text-alt text-yellow-700">{{ $message }}</span>
                    </label>
                    @enderror
                    @error('minute')
                    <label class="label">
                        <span class="label-text-alt text-yellow-700">{{ $message }}</span>
                    </label>
                    @enderror
                </div>

                {{-- Url --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">WebSite</span>
                    </label>
                    <input type="text" class="input input-bordered @error('url')input-error @enderror" placeholder="http://" wire:model.defer="url" @if($disabled) disabled="disabled" @endif>
                    @error('url')
                    <label class="label">
                        <span class="label-text-alt text-yellow-700">{{ $message }}</span>
                    </label>
                    @enderror
                </div>

                {{-- Generate --}}
                <button
                    class="btn"
                    wire:click="generate"
                    @if($disabled) disabled="disabled" @endif
                >
                    QrCode
                </button>
            @endif

            {{-- @dump($qrcode) --}}
            @if (!is_null($qrcode))
                {{-- Sizes --}}
                <div class="space-x-2 flex items-center justify-start">
                    <span>Size:</span>
                    <div class="w-1/4">
                        <select class="select select-bordered select-sm w-full max-w-xs @error('size')select-error @enderror" wire:model="size" @if($disabled) disabled="disabled" @endif>
                          <option disabled="" selected="">Select your size</option>
                          <option value="sm">sm</option>
                          <option value="md">md</option>
                          <option value="lg">lg</option>
                          <option value="xl">xl</option>
                        </select>
                        @error('size')
                        <label class="label">
                            <span class="label-text-alt text-yellow-700">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="visible-print text-center my-3">
                    {!! $qrcode !!}
                </div>
                <p class="my-2">
                    Click ici for showing:
                    <a target="_blank" href="{{ $fullUrl }}" class="link">ici</a>
                </p>
                <div class="flex items-center justify-cenetr space-x-1">
                    <span>Downloads: </span>

                    {{-- SVG --}}
                    <button class="btn btn-sm btn-outline" wire:click="exportSVG">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        SVG
                    </button>

                    {{-- PNG --}}
                    <button class="btn btn-sm btn-outline" wire:click="exportPNG">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        PNG
                    </button>
                </div>
                <div class="flex items-center justify-cenetr space-x-1">
                    <span>Share it: </span>

                    {{-- Facebook --}}
                    {{-- <button class="btn btn-sm btn-circle" wire:click="shareFacebook">
                        Fb
                    </button> --}}

                    {{-- Gmail --}}
                    <a href="#shareEmail" class="btn btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </a>
                    {{-- modal share --}}
                    <div id="shareEmail" class="modal" style="z-index: 999999;">
                      <div class="modal-box">
                        {{-- if success send email --}}
                        @if ($successSend)
                        <div class="alert alert-success">
                          <div class="flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <label>Sent Succesfully</label>
                          </div>
                        </div>

                        <div class="modal-action justify-center">
                          <a href="#" class="btn">Close</a>
                        </div>
                        @else {{-- if not success --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">E-mail</span>
                            </label>
                            <input type="email" name="email" wire:model.defer="email" placeholder="E-mail" class="input input-bordered @error('email')textarea-error @enderror">
                            @error('email')
                            <label class="label">
                                <span class="label-text-alt text-yellow-700">{{ $message }}</span>
                            </label>
                            @enderror
                        </div>

                        <div class="modal-action">
                          <button class="btn btn-primary" wire:click="shareEmail">Send Email</button>
                          <a href="#" class="btn">Close</a>
                        </div>
                        @endif
                      </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- loading --}}
    <div class="modal" wire:loading.flex wire:loading.class="modal-open" style="z-index: 9999999;">
      <div class="modal-box flex items-center justify-center w-1/6">
        <svg width="38" height="38" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#000">
            <g fill="none" fill-rule="evenodd">
                <g transform="translate(1 1)" stroke-width="2">
                    <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                    <path d="M36 18c0-9.94-8.06-18-18-18">
                        <animateTransform
                            attributeName="transform"
                            type="rotate"
                            from="0 18 18"
                            to="360 18 18"
                            dur="1s"
                            repeatCount="indefinite"/>
                    </path>
                </g>
            </g>
        </svg>
      </div>
    </div>
</div>

@push('scripts')
    <script>
        // function ready() {
        var marker, map;
        document.addEventListener('livewire:load', function () {
            // if (map != undefined) { map.remove(); }
            map = L.map('map')
                    .setView([{{ $latitude }}, {{ $longitude }}], {{ $zoomLevel }});

            // add layer from OpenStreatMap
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add Marker
            @if (isset($latlng) && count($latlng) > 0)
            L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map);
            @endif

            function onMapClick(e) {
                var latlng = e.latlng;
                marker = L.marker([latlng.lat, latlng.lng]).addTo(map);
                Livewire.emit('enabled', latlng, map.getZoom());
            }

            map.once('click', onMapClick);
        });

        function remove() {
            map.removeLayer(marker);
            Livewire.emit('remove');
        }
            // console.log('ready')
        // }
        // ready();
        // document.addEventListener("turbo:load", ready);
    </script>
@endpush
