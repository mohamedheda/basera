<?php

namespace App\Http\Services\Dashboard\Manager;

use App\Http\Helpers\Http;
use App\Http\Requests\Dashboard\Mangers\MangerRequest;
use App\Http\Traits\FileTrait;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\delete_model;
use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\store_model;
use function App\Http\Helpers\update_model;

class ManagerService
{
    use FileTrait;

    public function __construct(
        private ManagerRepositoryInterface $repository,
        private RoleRepositoryInterface $roleRepository,
    ) {}

    public function index()
    {

        $role = $this->roleRepository->getById(1, relations: ['managers']);

        return view('dashboard.site.managers.index', compact('role'));
    }

    public function create($id)
    {

        $role = $this->roleRepository->getById($id);

        return view('dashboard.site.managers.create', compact('role'));
    }

    public function store(MangerRequest $request)
    {

        DB::beginTransaction();
        try {
            $data = $request->except('id', 'image', 'password_confirmation');
            $data['is_active'] = $request->is_active == 'on' ? 1 : 0;

            if ($request->hasFile('image')) {
                $data['image'] = $this->image($request->file('image'), 'managers');
            }

            $roleId = $data['role_id'];
            unset($data['role_id']);

            $manger = store_model($this->repository, $data, true);

            if ($manger) {
                $manger->addRole($roleId);
            }
            DB::commit();

            return redirect()->route('roles.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $manager = $this->repository->getById($id);
        $role = $manager->roles->first();

        return view('dashboard.site.managers.edit', compact('role', 'manager'));
    }

    public function update(MangerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $manager = $this->repository->getById($id);
            $data = $request->except('id', 'image', 'password_confirmation');
            $data['is_active'] = $request->is_active == 'on' ? 1 : 0;

            if ($request->hasFile('image')) {
                $data['image'] = $this->image($request->file('image'), 'managers', $manager->image);

            }

            if (! isset($data['password'])) {
                unset($data['password']);
            }

            $roleId = $data['role_id'];
            unset($data['role_id']);

            update_model($this->repository, $id, $data);

            DB::commit();

            return redirect()->route('roles.mangers', ['id' => $roleId])
                ->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function toggle($id)
    {
        $manager = $this->repository->getById($id);
        $manager->is_active = ! $manager->is_active;
        $manager->save();

        return responseSuccess(Http::OK, __('messages.updated_successfully'), ['success' => true, 'is_active' => $manager->is_active]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $manger = $this->repository->getById($id);
            if ($manger->image) {
                $this->deleteFile($manger->image);
            }
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
}
