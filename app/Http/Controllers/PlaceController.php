<?php

namespace App\Http\Controllers;

use App\Models\Placed;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index(Placed $placed, Request $request)
    {
        abort_if(! $request->hasValidSignature(), 401);

        $placed->increment('count');

        return view('place', [
            'placed' => $placed,
        ]);
    }

    public function myplaces(Request $request)
    {
        $places = $request->user()->placeds()->paginate(4);

        return view('my-places', [
            'places' => $places,
        ]);
    }

    public function update(Placed $placed)
    {
        return view('index', [
            'place' => $placed,
        ]);
    }

    public function destroy(Placed $placed)
    {
        $placed->delete();

        return redirect()->route('myplaces')->with('success', 'succed delete');
    }

    public function destroyAll(Request $request)
    {
        $request->user()->placeds()->delete();

        return redirect()->route('myplaces');
    }
}
