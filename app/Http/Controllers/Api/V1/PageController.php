<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\PageService;

class PageController extends Controller
{
    public function __construct(private readonly PageService $service) {}

    public function index()
    {
        return $this->service->getAllPages();
    }

    public function show($slug)
    {
        return $this->service->getPageBySlug($slug);
    }
}
