<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    protected $provider = [ "google", "facebook" ];

    /**
     * Redirect the user to specific provider authentication page.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function redirect (Request $request) {
        $provider = strtolower($request->provider);

        if (in_array($provider, $this->provider)) {
            return Socialite::driver($provider)->redirect();
        }
        abort(404);
    }

    /**
     * Obtain the user information from provider
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function callback (Request $request) {
        $provider = strtolower($request->provider);

        if (in_array($provider, $this->provider)) {
            $data = Socialite::driver($request->provider)->user();

            if ($provider === "google") {
                $user = User::where('google_id', $data->getId())->first();
            } else if ($provider === "facebook") {
                $user = User::where('facebook_id', $data->getId())->first();
            }

            if ($user) {
                Auth::login($user);
                return redirect()->route("home");
            } else {
                $userNewData = [
                    'name' => $this->userName($provider, $data->getName()),
                    'email' => $data->getEmail(),
                    'password' => bcrypt('azertazert'),
                ];
                if ($provider === "google") {
                    $userNewData["first_name"] = $data->user['given_name'];
                    $userNewData["last_name"] = $data->user['family_name'];
                    $userNewData["google_id"] = $data->getId();
                } else if ($provider === "facebook") {
                    $fullName = explode(" ", $data->getName());
                    $userNewData["first_name"] = $fullName[0];
                    $userNewData["last_name"] = $fullName[1];
                    $userNewData["facebook_id"] = $data->getId();
                }
                $newUser = User::create($userNewData);
                Auth::login($newUser);
                return redirect()->route("my-account.update-password");
            }
        }
        abort(404);
    }

    private function userName (String $provider, String $username) {
        $username = str_replace(" ", "_", strtolower($username));
        if ($provider === "google") {
            $username .= "_gl";
        } else if ($provider === "facebook") {
            $username .= "_fb";
        }
        return $username;
    }
}
