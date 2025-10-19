<?php

namespace App\Http\Services\Dashboard\Page;

use App\Http\Helpers\Http;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class PageService
{
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.site.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('dashboard.site.pages.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            Page::create($data);
            DB::commit();

            return redirect()->route('pages.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('dashboard.site.pages.edit', compact('page'));
    }

    public function update($request, $id)
    {
        try {
            $page = Page::findOrFail($id);
            $data = $request->validated();

            $page->update($data);

            return redirect()->route('pages.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $page = Page::findOrFail($id);
            $page->delete();

            return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function toggleStatus($id)
    {
        try {
            $page = Page::findOrFail($id);
            $page->update(['is_active' => !$page->is_active]);

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }
}
