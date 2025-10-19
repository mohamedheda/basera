<?php

namespace App\Http\Controllers\Dashboard\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Page\PageRequest;
use App\Http\Services\Dashboard\Page\PageService;

class PageController extends Controller
{
    public function __construct(private readonly PageService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(PageRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(PageRequest $request, string $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }

    public function toggleStatus(string $id)
    {
        return $this->service->toggleStatus($id);
    }
}
