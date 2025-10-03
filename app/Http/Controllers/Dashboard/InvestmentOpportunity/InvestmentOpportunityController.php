<?php

namespace App\Http\Controllers\Dashboard\InvestmentOpportunity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\InvestmentOpportunity\InvestmentOpportunityRequest;
use App\Http\Services\Dashboard\InvestmentOpportunity\InvestmentOpportunityService;

class InvestmentOpportunityController extends Controller
{
    public function __construct(private readonly InvestmentOpportunityService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(InvestmentOpportunityRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(InvestmentOpportunityRequest $request, string $id)
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
