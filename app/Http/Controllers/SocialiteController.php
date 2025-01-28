<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class SocialiteController extends Controller
{
    //


    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('mylogin');
}


    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthentication()
    {
        try{

        
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id',$googleUser->id)->first();
        if($user)
        {
            Auth::login($user);
            return redirect()->route('home');
        }
        else{
           $userData= User::create([
                'name'=>$googleUser->name,
                     'email'=>$googleUser->email,
                     'password'=>Hash::make('password'),
                     'google_id'=> $googleUser->id,
            ]);

            if($userData)
            {
                Auth::login($userData);
                return redirect()->route('home');
            }
        }
    }catch(Exception $e)
    {

        dd($e);
    }
    }
}
