<?php

namespace App\Http\Controllers\Dashboard\RegistrationQuestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RegistrationQuestion\RegistrationQuestionRequest;
use App\Http\Services\Dashboard\RegistrationQuestion\RegistrationQuestionService;

class RegistrationQuestionController extends Controller
{
    public function __construct(private readonly RegistrationQuestionService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(RegistrationQuestionRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(RegistrationQuestionRequest $request, string $id)
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
