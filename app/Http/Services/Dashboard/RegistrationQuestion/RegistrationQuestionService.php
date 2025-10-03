<?php

namespace App\Http\Services\Dashboard\RegistrationQuestion;

use App\Http\Helpers\Http;
use App\Models\RegistrationQuestion;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class RegistrationQuestionService
{
    public function index()
    {
        $questions = RegistrationQuestion::orderBy('order', 'asc')->paginate(10);

        return view('dashboard.site.registration-questions.index', compact('questions'));
    }

    public function create()
    {
        return view('dashboard.site.registration-questions.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            if (isset($data['options_en']) && isset($data['options_ar'])) {
                $data['options'] = [
                    'en' => array_filter(explode(',', $data['options_en'])),
                    'ar' => array_filter(explode(',', $data['options_ar']))
                ];
                unset($data['options_en'], $data['options_ar']);
            }

            RegistrationQuestion::create($data);
            DB::commit();

            return redirect()->route('registration-questions.index')->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function edit($id)
    {
        $question = RegistrationQuestion::findOrFail($id);

        return view('dashboard.site.registration-questions.edit', compact('question'));
    }

    public function update($request, $id)
    {
        try {
            $question = RegistrationQuestion::findOrFail($id);
            $data = $request->validated();

            if (isset($data['options_en']) && isset($data['options_ar'])) {
                $data['options'] = [
                    'en' => array_filter(explode(',', $data['options_en'])),
                    'ar' => array_filter(explode(',', $data['options_ar']))
                ];
                unset($data['options_en'], $data['options_ar']);
            }

            $question->update($data);

            return redirect()->route('registration-questions.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $question = RegistrationQuestion::findOrFail($id);
            $question->delete();

            return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function toggleStatus($id)
    {
        try {
            $question = RegistrationQuestion::findOrFail($id);
            $question->update(['is_active' => !$question->is_active]);

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }
}
