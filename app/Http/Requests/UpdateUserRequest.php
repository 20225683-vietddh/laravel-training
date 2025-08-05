<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Cho phép tất cả users cập nhật user (có thể thêm logic authorization sau)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userId = $this->route('user'); // Lấy user ID từ route parameter

        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes', 
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($userId)
            ],
            'username' => [
                'sometimes', 
                'required', 
                'string', 
                'max:255', 
                'alpha_dash',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => ['sometimes', 'nullable', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'is_active' => ['sometimes', 'boolean'],
            'role_ids' => ['sometimes', 'array'],
            'role_ids.*' => ['exists:roles,id'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'Họ là trường bắt buộc.',
            'last_name.required' => 'Tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email phải có định dạng hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'username.required' => 'Username là trường bắt buộc.',
            'username.unique' => 'Username này đã được sử dụng.',
            'username.alpha_dash' => 'Username chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role_ids.array' => 'Role IDs phải là một mảng.',
            'role_ids.*.exists' => 'Role được chọn không tồn tại.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => 'họ',
            'last_name' => 'tên',
            'email' => 'email',
            'username' => 'username',
            'password' => 'mật khẩu',
            'is_active' => 'trạng thái hoạt động',
            'role_ids' => 'roles',
        ];
    }
}