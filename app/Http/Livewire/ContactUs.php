<?php

namespace App\Http\Livewire;

use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Livewire\Component;

class ContactUs extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|string|email',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $request = new Request();
        $request->replace([
            '_token' => csrf_token(),
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'isAjax' => true,
        ]);
        $contact = new ContactController();
        $contact->store($request);
    }

    public function render()
    {
        return view('livewire.contact-us');
    }
}
