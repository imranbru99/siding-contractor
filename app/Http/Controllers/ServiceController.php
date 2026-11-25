<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('site.services.index', [
            'services' => Service::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Service $service): View
    {
        return view('site.services.show', [
            'service' => $service,
            'others' => Service::query()->where('id', '!=', $service->id)->orderBy('sort_order')->take(3)->get(),
        ]);
    }
}
