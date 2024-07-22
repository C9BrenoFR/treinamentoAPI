<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use Illuminate\Http\Request;

class IdentityController extends Controller
{
    public function index()
    {
        $identities = Identity::all();
        return view('identity', compact('identities'));
    }
}
