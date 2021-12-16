<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Profile extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $success;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->success = false;
    }

    public function submit()
    {
        $this->success = false;
        $this->validate();

        $user = auth()->user();
        $user->name = $this->name;
        $user->email = $this->email;
        if (!is_null($this->password)) {
            $user->password = Hash::make($this->password);
        }
        $user->save();
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
