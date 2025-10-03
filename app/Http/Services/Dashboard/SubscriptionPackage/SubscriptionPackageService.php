<?php

namespace App\Http\Services\Dashboard\SubscriptionPackage;

use App\Http\Helpers\Http;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class SubscriptionPackageService
{
    public function index()
    {
        $packages = SubscriptionPackage::orderBy('duration_months', 'asc')->paginate(10);

        return view('dashboard.site.subscription-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('dashboard.site.subscription-packages.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            SubscriptionPackage::create($data);
            DB::commit();

            return redirect()->route('subscription-packages.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        return view('dashboard.site.subscription-packages.edit', compact('package'));
    }

    public function update($request, $id)
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);
            $data = $request->validated();

            $package->update($data);

            return redirect()->route('subscription-packages.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);

            // Check if package has subscriptions
            if ($package->userSubscriptions()->count() > 0) {
                return responseFail(Http::BAD_REQUEST, __('messages.Cannot delete package with active subscriptions'));
            }

            $package->delete();

            return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function toggleStatus($id)
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);
            $package->update(['is_active' => !$package->is_active]);

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function togglePopular($id)
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);
            $package->update(['is_popular' => !$package->is_popular]);

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }
}
