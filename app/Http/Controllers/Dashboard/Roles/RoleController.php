<?php

namespace App\Http\Controllers\Dashboard\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Role\RoleRequest;
use App\Http\Services\Dashboard\Roles\RoleService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:roles-read', ['index']),
            new Middleware('permission:roles-create', ['store', 'create']),
            new Middleware('permission:roles-update', ['update', 'edit']),
            new Middleware('permission:roles-delete', ['destroy']),
            new Middleware('permission:managers-read', ['managers']),
        ];
    }

    public function __construct(private RoleService $service) {}

    public function index()
    {
        return $this->service->index();
    }

    public function mangers($id)
    {
        return $this->service->mangers($id);
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(RoleRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit($id)
    {
        return $this->service->edit($id);
    }

    public function update(RoleRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
