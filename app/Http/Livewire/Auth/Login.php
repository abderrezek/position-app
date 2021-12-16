<?php

namespace App\Http\Livewire\Auth;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $login = new AuthenticatedSessionController();

        $loginRequest = new LoginRequest();
        $loginRequest->replace([
            'email' => $this->email,
            'password' => $this->password,
            'remember' => $this->remember,
        ]);

        $login->store($loginRequest);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
