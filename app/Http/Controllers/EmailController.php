<?php

namespace App\Http\Controllers;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

class EmailController extends Controller
{
    public function index()
    {
        return view('email');
    }

    public function sendVerification()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {

            if (Auth::user()->rolename === 'admin') {
                $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    
            }else {
    
                $this->redirectIntended(default: route('info', absolute: false), navigate: true);
            }

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

}
