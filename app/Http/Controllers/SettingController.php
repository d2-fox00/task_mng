<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        return view('view.setting');
    }

    public function delete()
    {
        Todo::where('userid', Auth::id())->delete();
        User::where('id', Auth::id())->delete();

        return redirect('/login');
    }
}
