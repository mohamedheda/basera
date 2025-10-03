<?php

namespace App\Http\Controllers\Dashboard\UserSubscription;

use App\Http\Controllers\Controller;
use App\Http\Services\Dashboard\UserSubscription\UserSubscriptionService;

class UserSubscriptionController extends Controller
{
    public function __construct(private readonly UserSubscriptionService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function show(string $id)
    {
        return $this->service->show($id);
    }

    public function updateStatus(string $id, string $status)
    {
        return $this->service->updateStatus($id, $status);
    }

    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }
}
