<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Cho phép tất cả users cập nhật task (có thể thêm logic authorization sau)
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
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'status' => ['sometimes', 'required', 'in:pending,in_progress,completed,cancelled'],
            'priority' => ['sometimes', 'in:low,medium,high,urgent'],
            'due_date' => ['sometimes', 'nullable', 'date'],
            'user_id' => ['sometimes', 'required', 'exists:users,id'],
            'category' => ['sometimes', 'nullable', 'string', 'max:100'],
            'estimated_hours' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:999.99'],
            'actual_hours' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:999.99'],
            'completed_at' => ['sometimes', 'nullable', 'date'],
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
            'title.required' => 'Tiêu đề task là trường bắt buộc.',
            'title.max' => 'Tiêu đề task không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Trạng thái task là trường bắt buộc.',
            'status.in' => 'Trạng thái task phải là một trong: pending, in_progress, completed, cancelled.',
            'priority.in' => 'Độ ưu tiên phải là một trong: low, medium, high, urgent.',
            'due_date.date' => 'Ngày hạn phải có định dạng ngày hợp lệ.',
            'user_id.required' => 'Người được gán task là trường bắt buộc.',
            'user_id.exists' => 'Người dùng được chọn không tồn tại.',
            'category.max' => 'Danh mục không được vượt quá 100 ký tự.',
            'estimated_hours.numeric' => 'Số giờ ước tính phải là số.',
            'estimated_hours.min' => 'Số giờ ước tính phải lớn hơn hoặc bằng 0.',
            'estimated_hours.max' => 'Số giờ ước tính không được vượt quá 999.99.',
            'actual_hours.numeric' => 'Số giờ thực tế phải là số.',
            'actual_hours.min' => 'Số giờ thực tế phải lớn hơn hoặc bằng 0.',
            'actual_hours.max' => 'Số giờ thực tế không được vượt quá 999.99.',
            'completed_at.date' => 'Ngày hoàn thành phải có định dạng ngày hợp lệ.',
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
            'title' => 'tiêu đề',
            'description' => 'mô tả',
            'status' => 'trạng thái',
            'priority' => 'độ ưu tiên',
            'due_date' => 'ngày hạn',
            'user_id' => 'người được gán',
            'category' => 'danh mục',
            'estimated_hours' => 'số giờ ước tính',
            'actual_hours' => 'số giờ thực tế',
            'completed_at' => 'ngày hoàn thành',
        ];
    }
}