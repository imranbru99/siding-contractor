<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('site.home', [
            'services' => Service::query()->orderBy('sort_order')->take(6)->get(),
            'posts' => BlogPost::query()->where('is_published', true)->latest('published_at')->take(3)->get(),
            'stats' => [
                'jobs' => Project::query()->count(),
                'completed' => Project::query()->where('status', 'completed')->count(),
                'sqft' => (int) Project::query()->sum('sqft'),
            ],
        ]);
    }
}
