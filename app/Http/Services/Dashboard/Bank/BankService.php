<?php

namespace App\Http\Services\Dashboard\Bank;

use App\Http\Helpers\Http;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class BankService
{
    public function index()
    {
        $banks = Bank::orderBy('name_en', 'asc')->paginate(10);

        return view('dashboard.site.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('dashboard.site.banks.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            Bank::create($data);
            DB::commit();

            return redirect()->route('banks.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);

        return view('dashboard.site.banks.edit', compact('bank'));
    }

    public function update($request, $id)
    {
        try {
            $bank = Bank::findOrFail($id);
            $data = $request->validated();

            $bank->update($data);

            return redirect()->route('banks.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $bank = Bank::findOrFail($id);
            $bank->delete();

            return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function toggleStatus($id)
    {
        try {
            $bank = Bank::findOrFail($id);
            $bank->update(['is_active' => !$bank->is_active]);

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }
}
