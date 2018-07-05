<?php

namespace App\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Illuminate\Http\Request;

/**
 * @Middleware({"web", "auth"})
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @Get("dashboard", as="dashboard")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }
}
