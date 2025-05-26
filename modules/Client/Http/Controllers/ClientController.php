<?php

namespace Modules\Client\Http\Controllers;

use App\TransmedicControllerApp;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author narnowin195@gmail.com
 */
class ClientController extends TransmedicControllerApp
{
    public function index(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function show($any) :Response
    {
        return Inertia::render($any);
    }
}
