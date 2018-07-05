<?php

namespace App\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Illuminate\Http\Request;

/**
 * @Middleware("web")
 * @Middleware("auth", except={"index"})
 */
class HomeController extends Controller
{
    /**
     * @Get("/", as="welcome")
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route( 'login');
    }

    /**
     * @Get("home", as="home")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }
}
