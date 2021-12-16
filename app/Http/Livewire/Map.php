<?php

namespace App\Http\Livewire;

use App\Mail\Share;
use App\Models\Placed;
use App\Models\PlacedsUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Map extends Component
{
    public $latitude;
    public $longitude;
    public $zoomLevel;
    public $latlng;
    public $zoom;
    public $disabled;
    public $qrcode;
    public $fullUrl;
    public $url;
    public $message;
    public $enabledTime;
    public $hour;
    public $minute;
    public $size;
    public $email;
    public $place;
    public $successSend;
    public $uuid;

    protected $listeners = ['enabled', 'remove'];

    protected function rules()
    {
        return [
            'latlng' => 'required|array:lat,lng',
            'size' => [
                'required',
                Rule::in(['sm', 'md', 'lg', 'xl']),
            ],
            'zoom' => 'required|integer',
            'message' => 'nullable|string',
            'enabledTime' => 'required|boolean',
            'hour' => 'nullable|numeric|min:0|max:23',
            'minute' => 'nullable|numeric|min:0|max:59',
            'url' => 'nullable|string|url',
        ];
    }

    public function mount(Request $request)
    {
        if (is_null($request->placed)) {
            // first
            $this->latitude = config('leaflet.map_center_latitude');
            $this->longitude = config('leaflet.map_center_longitude');
            $this->zoomLevel = config('leaflet.zoom_level');
            $this->disabled = true;
            $this->enabledTime = true;
            $time = explode(":", now()->toTimeString());
            $this->hour = $time[0];
            $this->minute = $time[1];
            $this->size = 'sm';
        } else {
            // update
            $p = $request->placed;
            $this->uuid = $p->uuid;
            $this->latlng = [
                'lat' => $p->lat,
                'lng' => $p->lng,
            ];
            $this->zoom = $p->zoom;
            $this->latitude = $p->lat;
            $this->longitude = $p->lng;
            $this->zoomLevel = $p->zoom;
            $this->disabled = false;
            if (!is_null($p->message)) {
                $this->message = $p->message;
            }
            if (!is_null($p->url)) {
                $this->url = $p->url;
            }
            if ($p->time !== "") {
                $this->enabledTime = true;
                $t = explode(":", $p->time);
                $this->hour = $t[0];
                $this->minute = $t[1];
            } else {
                $this->enabledTime = false;
                $time = explode(":", now()->toTimeString());
                $this->hour = $time[0];
                $this->minute = $time[1];
            }
            $this->size = 'sm';
        }
        $this->successSend = false;
    }

    public function enabled($latlng, $zoom)
    {
        $this->disabled = false;
        $this->latlng = $latlng;
        $this->zoom = $zoom;
    }

    public function remove()
    {
        $this->disabled = true;
        $this->latlng = null;
        $this->zoom = null;
    }

    public function generate()
    {
        $this->validate();

        // insert
        if (is_null($this->uuid)) {
            $placedCreated = [
                'lat' => $this->latlng['lat'],
                'lng' => $this->latlng['lng'],
                'zoom' => $this->zoom,
                'email',
            ];
            if ($this->message !== "" && !is_null($this->message)) {
                $placedCreated['message'] = $this->message;
            }
            if ($this->url !== "" && !is_null($this->url)) {
                $placedCreated['url'] = $this->url;
            }
            if ($this->enabledTime) {
                $placedCreated['time'] = Carbon::createFromFormat(
                    'H:i:s', "{$this->hour}:{$this->minute}:00"
                );
            }
            $placed = Placed::create($placedCreated);
            if (Auth::check()) {
                PlacedsUser::create([
                    'user_id' => auth()->user()->id,
                    'placed_id' => $placed->id,
                ]);
            }
            $this->place = $placed->uuid;
            $this->fullUrl = URL::signedRoute('place', $placed);
            $this->qrcode = QrCode::size($this->getSize($this->size))
                ->generate($this->fullUrl)
                ->toHtml();
        } else { // update
            $placed = Placed::where('uuid', '=', $this->uuid)->firstOrFail();
            $placed->lat = $this->latlng['lat'];
            $placed->lng = $this->latlng['lng'];
            $placed->zoom = $this->zoom;
            if ($this->message !== "" && !is_null($this->message)) {
                $placed->message = $this->message;
            } else if ($this->message === "" || is_null($this->message)) {
                $placed->message = null;
            }
            if ($this->url !== "" && !is_null($this->url)) {
                $placed->url = $this->url;
            } else if ($this->url === "" || is_null($this->url)) {
                $placed->url = null;
            }
            if ($this->enabledTime) {
                $placed->time = Carbon::createFromFormat(
                    'H:i:s', "{$this->hour}:{$this->minute}:00"
                );
            } else {
                $placed->time = null;
            }
            $placed->save();
            $this->fullUrl = URL::signedRoute('place', $placed);
            $this->qrcode = QrCode::size($this->getSize($this->size))
                ->generate($this->fullUrl)
                ->toHtml();
        }
    }

    public function updatedSize()
    {
        $this->qrcode = QrCode::size($this->getSize($this->size))
            ->generate($this->fullUrl)
            ->toHtml();
    }

    private function getSize($size = 'sm')
    {
        switch ($size) {
            case 'sm':
                return 150;
            case 'md':
                return 250;
            case 'lg':
                return 350;
            case 'xl':
                return 450;
        }
    }

    public function exportSVG()
    {
        $qr_code = QrCode::size($this->getSize($this->size))
            ->format('svg')
            ->generate($this->fullUrl);
        $file_name = Str::random(10) . '.svg';
        Storage::disk('public')->put($file_name, $qr_code);
        $ds = DIRECTORY_SEPARATOR;
        return response()->download(storage_path("app{$ds}public{$ds}{$file_name}"));
    }

    public function exportPNG()
    {
        $file_name = Str::random(10) . '.png';
        $ds = DIRECTORY_SEPARATOR;
        $path = storage_path("app{$ds}public{$ds}{$file_name}");
        $qr_code = QrCode::format('png')
            ->size($this->getSize($this->size))
            ->generate($this->fullUrl, $path);
        return response()->download($path);
    }

    public function shareEmail()
    {
        if (is_null($this->fullUrl)) {
            $this->addError('email', 'QrCode must be generate');
            return;
        }
        if (is_null($this->email)) {
            $this->addError('email', 'E-mail required');
            return;
        }
        Mail::to($this->email)->send(new Share($this->fullUrl, $this->place));
        $this->successSend = true;
    }

    public function render()
    {
        return view('livewire.map');
    }
}
