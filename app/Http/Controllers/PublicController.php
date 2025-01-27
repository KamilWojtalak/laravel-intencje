<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $priests = User::getPriests();

        return view(
            'public.index',
            [
                'priests' => $priests
            ]
        );
    }
}
