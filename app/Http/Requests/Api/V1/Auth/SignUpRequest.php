<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')],
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols()],
            'national_id' => ['required', 'string', 'max:50', Rule::unique('users', 'national_id')],
            'date_of_birth' => ['required', 'date', 'before:today'],

            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'family_members_count' => ['required', 'integer', 'min:1'],
            'education_level' => ['required', 'in:high_school,diploma,bachelor,master,phd,other'],
            'annual_income' => ['required', 'numeric', 'min:0'],
            'total_savings' => ['required', 'numeric', 'min:0'],
            'bank_id' => ['required', 'exists:banks,id'],

            'answers' => ['required', 'array', 'min:6'],
            'answers.*.question_id' => ['required', 'exists:registration_questions,id'],
            'answers.*.answer' => ['required', 'in:Yes,No,yes,no,نعم,لا'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم الكامل مطلوب',
            'name.string' => 'الاسم الكامل يجب أن يكون نص',
            'name.max' => 'الاسم الكامل يجب ألا يتجاوز 255 حرف',

            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',

            'phone.required' => 'رقم الجوال مطلوب',
            'phone.string' => 'رقم الجوال يجب أن يكون نص',
            'phone.max' => 'رقم الجوال يجب ألا يتجاوز 20 رقم',
            'phone.unique' => 'رقم الجوال مستخدم بالفعل',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',

            'national_id.required' => 'رقم الهوية مطلوب',
            'national_id.string' => 'رقم الهوية يجب أن يكون نص',
            'national_id.max' => 'رقم الهوية يجب ألا يتجاوز 50 حرف',
            'national_id.unique' => 'رقم الهوية مستخدم بالفعل',

            'date_of_birth.required' => 'تاريخ الميلاد مطلوب',
            'date_of_birth.date' => 'تاريخ الميلاد يجب أن يكون تاريخ صحيح',
            'date_of_birth.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم',

            'marital_status.required' => 'الحالة الاجتماعية مطلوبة',
            'marital_status.in' => 'الحالة الاجتماعية المحددة غير صحيحة',

            'family_members_count.required' => 'عدد أفراد الأسرة مطلوب',
            'family_members_count.integer' => 'عدد أفراد الأسرة يجب أن يكون رقم صحيح',
            'family_members_count.min' => 'عدد أفراد الأسرة يجب أن يكون 1 على الأقل',

            'education_level.required' => 'مستوى التعليم مطلوب',
            'education_level.in' => 'مستوى التعليم المحدد غير صحيح',

            'annual_income.required' => 'الدخل السنوي مطلوب',
            'annual_income.numeric' => 'الدخل السنوي يجب أن يكون رقم',
            'annual_income.min' => 'الدخل السنوي يجب أن يكون 0 أو أكثر',

            'total_savings.required' => 'إجمالي التوفير مطلوب',
            'total_savings.numeric' => 'إجمالي التوفير يجب أن يكون رقم',
            'total_savings.min' => 'إجمالي التوفير يجب أن يكون 0 أو أكثر',

            'bank_id.required' => 'البنك الذي تتعامل معه مطلوب',
            'bank_id.exists' => 'البنك المحدد غير موجود',

            'answers.required' => 'يجب الإجابة على أسئلة تقييم المعرفة بالمخاطر',
            'answers.array' => 'الإجابات يجب أن تكون مصفوفة',
            'answers.min' => 'يجب الإجابة على جميع الأسئلة الستة',
            'answers.*.question_id.required' => 'معرف السؤال مطلوب',
            'answers.*.question_id.exists' => 'السؤال المحدد غير موجود',
            'answers.*.answer.required' => 'الإجابة مطلوبة',
            'answers.*.answer.in' => 'الإجابة يجب أن تكون نعم أو لا',
        ];
    }
}
