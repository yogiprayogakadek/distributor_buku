<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function cart()
    {
        $view = [
            'data' => view('templates.partials.cart')->with([
                'cart' => cart()
            ])->render()
        ];

        return response()->json($view);
    }
}
