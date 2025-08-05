<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'user_id',
        'category',
        'estimated_hours',
        'actual_hours',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
    ];

    /**
     * The task belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge badge-secondary">Chờ xử lý</span>',
            'in_progress' => '<span class="badge badge-warning">Đang thực hiện</span>',
            'completed' => '<span class="badge badge-success">Hoàn thành</span>',
            'cancelled' => '<span class="badge badge-danger">Đã hủy</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-light">Không xác định</span>';
    }

    /**
     * Get priority badge HTML.
     */
    public function getPriorityBadgeAttribute(): string
    {
        $badges = [
            'low' => '<span class="badge badge-info">Thấp</span>',
            'medium' => '<span class="badge badge-primary">Trung bình</span>',
            'high' => '<span class="badge badge-warning">Cao</span>',
            'urgent' => '<span class="badge badge-danger">Khẩn cấp</span>',
        ];

        return $badges[$this->priority] ?? '<span class="badge badge-secondary">Chưa xác định</span>';
    }
}
