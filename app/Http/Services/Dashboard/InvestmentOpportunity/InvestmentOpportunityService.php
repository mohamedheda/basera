<?php

namespace App\Http\Services\Dashboard\InvestmentOpportunity;

use App\Http\Helpers\Http;
use App\Models\InvestmentOpportunity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class InvestmentOpportunityService
{
    public function index()
    {
        $opportunities = InvestmentOpportunity::orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => InvestmentOpportunity::count(),
            'active' => InvestmentOpportunity::where('is_active', true)->count(),
            'halal' => InvestmentOpportunity::where('is_halal', true)->count(),
            'average_return' => round(InvestmentOpportunity::avg('expected_return_percentage'), 2),
        ];

        return view('dashboard.site.investment-opportunities.index', compact('opportunities', 'stats'));
    }

    public function create()
    {
        return view('dashboard.site.investment-opportunities.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('investments', 'public');
            }

            InvestmentOpportunity::create($data);
            DB::commit();

            return redirect()->route('investment-opportunities.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $opportunity = InvestmentOpportunity::findOrFail($id);

        return view('dashboard.site.investment-opportunities.edit', compact('opportunity'));
    }

    public function update($request, $id)
    {
        try {
            $opportunity = InvestmentOpportunity::findOrFail($id);
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($opportunity->image) {
                    Storage::disk('public')->delete($opportunity->image);
                }
                $data['image'] = $request->file('image')->store('investments', 'public');
            }

            $opportunity->update($data);

            return redirect()->route('investment-opportunities.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunity = InvestmentOpportunity::findOrFail($id);

            // Delete image if exists
            if ($opportunity->image) {
                Storage::disk('public')->delete($opportunity->image);
            }

            $opportunity->delete();

            return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function toggleStatus($id)
    {
        try {
            $opportunity = InvestmentOpportunity::findOrFail($id);
            $opportunity->update(['is_active' => !$opportunity->is_active]);

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }
}
