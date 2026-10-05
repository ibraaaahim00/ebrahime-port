<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFactory;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $projects = Project::query()->visible()->orderBy('updated_at')->get();

        return ResponseFactory::view('seo.sitemap', ['projects' => $projects], 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']);
    }
}
