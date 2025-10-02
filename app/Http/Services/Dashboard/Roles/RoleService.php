<?php

namespace App\Http\Services\Dashboard\Roles;

use App\Http\Helpers\Http;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\delete_model;
use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\store_model;
use function App\Http\Helpers\update_model;

class RoleService
{
    public function __construct(
        private RoleRepositoryInterface $repository,

        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function index()
    {
        $roles = $this->repository->paginate(20);

        return view('dashboard.site.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionRepository->getAll();

        return view('dashboard.site.roles.create', compact('permissions'));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('permissions');
            $data['name'] = str_replace(' ', '-', strtolower($data['display_name_en']));
            $role = store_model($this->repository, $data, true);
            $role->permissions()->attach($request->permissions);
            DB::commit();

            return redirect()->route('roles.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            //            return $e->getMessage();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $role = $this->repository->getById($id, relations: ['permissions']);
        $permissions = $this->permissionRepository->getAll();

        return view('dashboard.site.roles.edit', compact('role', 'permissions'));
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('permissions');
            $data['name'] = str_replace(' ', '-', strtolower($data['display_name_en']));
            $role = update_model($this->repository, $id, $data, true);
            $role->permissions()->sync($request->permissions);
            DB::commit();

            return redirect()->route('roles.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $role = $this->repository->getById($id);
            $role->permissions()->detach();
            $deleted = delete_model($this->repository, $id);
            DB::commit();
            if ($deleted) {
                return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
            } else {
                return responseFail(Http::NOT_FOUND, __('messages.Not Found or Already Deleted'));
            }
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, ['error' => $e->getMessage(), __('messages.Something went wrong')]);
        }
    }

    public function mangers($id)
    {
        $role = $this->repository->getById($id, relations: ['managers']);
        $managers = $role->managers()->paginate(10);

        return view('dashboard.site.managers.index', compact('managers', 'role'));
    }
}
