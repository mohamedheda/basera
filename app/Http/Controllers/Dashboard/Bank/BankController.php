<?php

namespace App\Http\Controllers\Dashboard\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Bank\BankRequest;
use App\Http\Services\Dashboard\Bank\BankService;

class BankController extends Controller
{
    public function __construct(private readonly BankService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(BankRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(BankRequest $request, string $id)
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
