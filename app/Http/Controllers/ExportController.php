<?php

namespace App\Http\Controllers;

use App\Models\Placed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ExportController extends Controller
{
    public function __invoke(Request $request)
    {
        $types = ['svg', 'png'];
        $type = strtolower($request->type);
        if (!in_array($type, $types)) {
            return view('downloads', [
                'invalid' => 'invalid URL, Type not support'
            ]);
        }

        $sizes = ['sm', 'md', 'lg', 'xl'];
        $size = strtolower($request->size);
        if (!in_array($size, $sizes)) {
            return view('downloads', [
                'invalid' => 'invalid URL, Size not support'
            ]);
        }

        $placed = Placed::where('uuid', '=', $request->uuid)->firstOrFail();

        $url = URL::signedRoute('place', $placed);

        $file_name = Str::random(10) . '.' . $type;

        $ds = DIRECTORY_SEPARATOR;
        $path = storage_path("app{$ds}public{$ds}{$file_name}");

        $qr_code = QrCode::size($this->getSize($size))
                    ->format($type);
        if ($type === "svg") {
            $qr_code = $qr_code->generate($url);
            Storage::disk('public')->put($file_name, $qr_code);
        } else if ($type === "png") {
            $qr_code->generate($url, $path);
        }
        return response()->download($path);
        // return view('downloads', [
        //     'path' => $path,
        // ]);
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
}
