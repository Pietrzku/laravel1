<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainPage extends Controller
{
    //public function __invoke()
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            //dd('jestem zalogowany');
        }

        $user = Auth::user();
        //$user = $request->user();
        $id = Auth::id();

        //Auth::logout();

        return view('home.main', ['user' => $user]);
    }
}
