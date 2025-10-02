<?php

namespace App\Http\Controllers\Dashboard\Mangers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Mangers\MangerRequest;
use App\Http\Services\Dashboard\Manager\ManagerService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MangerController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [

            new Middleware('permission:managers-create', ['store', 'create']),
            new Middleware('permission:managers-update', ['update', 'edit', 'toggle']),
            new Middleware('permission:managers-delete', ['destroy']),
        ];
    }

    public function __construct(private ManagerService $service) {}

    public function create($id)
    {
        return $this->service->create($id);
    }

    public function store(MangerRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit($id)
    {
        return $this->service->edit($id);
    }

    public function toggle($id)
    {
        return $this->service->toggle($id);
    }

    public function update(MangerRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
