<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Cho phép tất cả users tạo user mới (có thể thêm logic authorization sau)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            'password' => ['required', 'confirmed', Password::min(8)
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
            'password.required' => 'Mật khẩu là trường bắt buộc.',
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