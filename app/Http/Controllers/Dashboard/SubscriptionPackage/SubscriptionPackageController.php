<?php

namespace App\Http\Controllers\Dashboard\SubscriptionPackage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SubscriptionPackage\SubscriptionPackageRequest;
use App\Http\Services\Dashboard\SubscriptionPackage\SubscriptionPackageService;

class SubscriptionPackageController extends Controller
{
    public function __construct(private readonly SubscriptionPackageService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(SubscriptionPackageRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(SubscriptionPackageRequest $request, string $id)
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

    public function togglePopular(string $id)
    {
        return $this->service->togglePopular($id);
    }
}
