<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * Using Query Builder
     *
     * @return View
     */
    public function index(Request $request): View
    {
        // Sử dụng Query Builder để lấy dữ liệu
        $query = DB::table('tasks')
            ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
            ->select(
                'tasks.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_full_name')
            );

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tasks.title', 'like', "%{$search}%")
                  ->orWhere('tasks.description', 'like', "%{$search}%")
                  ->orWhere('tasks.category', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            $query->where('tasks.status', $status);
        }

        // Filter by priority
        if ($priority = $request->get('priority')) {
            $query->where('tasks.priority', $priority);
        }

        // Filter by user
        if ($userId = $request->get('user_id')) {
            $query->where('tasks.user_id', $userId);
        }

        // Order by newest first
        $tasks = $query->orderBy('tasks.created_at', 'desc')
                      ->paginate(10);

        // Get statistics using Query Builder
        $stats = [
            'total_tasks' => DB::table('tasks')->count(),
            'pending_tasks' => DB::table('tasks')->where('status', 'pending')->count(),
            'in_progress_tasks' => DB::table('tasks')->where('status', 'in_progress')->count(),
            'completed_tasks' => DB::table('tasks')->where('status', 'completed')->count(),
            'cancelled_tasks' => DB::table('tasks')->where('status', 'cancelled')->count(),
        ];

        // Get users for filter dropdown using Query Builder
        $users = DB::table('users')
            ->select('id', 'first_name', 'last_name')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->get();

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Tasks Management', 'url' => '#']
        ];

        return view('tasks.index', compact('tasks', 'breadcrumbs', 'stats', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        // Get users using Query Builder
        $users = DB::table('users')
            ->select('id', 'first_name', 'last_name')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->get();

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Tasks Management', 'url' => route('tasks.index')],
            ['title' => 'Create Task', 'url' => '#']
        ];

        return view('tasks.create', compact('users', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     * Using Query Builder
     *
     * @param  StoreTaskRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        try {
            // Sử dụng Query Builder để insert task
            $taskId = DB::table('tasks')->insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'priority' => $request->priority ?? 'medium',
                'due_date' => $request->due_date,
                'user_id' => $request->user_id,
                'category' => $request->category,
                'estimated_hours' => $request->estimated_hours,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()
                ->route('tasks.show', $taskId)
                ->with('success', 'Task đã được tạo thành công!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo task: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Using Query Builder
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id): View
    {
        // Sử dụng Query Builder để lấy task với thông tin user
        $task = DB::table('tasks')
            ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
            ->select(
                'tasks.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.username',
                DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_full_name')
            )
            ->where('tasks.id', $id)
            ->first();

        if (!$task) {
            abort(404, 'Task not found');
        }

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Tasks Management', 'url' => route('tasks.index')],
            ['title' => 'Task Detail', 'url' => '#']
        ];

        return view('tasks.show', compact('task', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     * Using Query Builder
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        // Get task using Query Builder
        $task = DB::table('tasks')->where('id', $id)->first();
        
        if (!$task) {
            abort(404, 'Task not found');
        }

        // Get users using Query Builder
        $users = DB::table('users')
            ->select('id', 'first_name', 'last_name')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->get();

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Tasks Management', 'url' => route('tasks.index')],
            ['title' => 'Edit Task', 'url' => '#']
        ];

        return view('tasks.edit', compact('task', 'users', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     * Using Query Builder
     *
     * @param  UpdateTaskRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, int $id): RedirectResponse
    {
        try {
            // Check if task exists using Query Builder
            $task = DB::table('tasks')->where('id', $id)->first();
            
            if (!$task) {
                abort(404, 'Task not found');
            }

            // Prepare data for update
            $data = array_filter([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'user_id' => $request->user_id,
                'category' => $request->category,
                'estimated_hours' => $request->estimated_hours,
                'actual_hours' => $request->actual_hours,
                'completed_at' => $request->completed_at,
                'updated_at' => now(),
            ], function ($value) {
                return $value !== null;
            });

            // Auto set completed_at if status is completed
            if ($request->status === 'completed' && !$request->completed_at) {
                $data['completed_at'] = now();
            }

            // Sử dụng Query Builder để update task
            DB::table('tasks')
                ->where('id', $id)
                ->update($data);

            return redirect()
                ->route('tasks.show', $id)
                ->with('success', 'Task đã được cập nhật thành công!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật task: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Using Query Builder
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Check if task exists using Query Builder
            $task = DB::table('tasks')->where('id', $id)->first();
            
            if (!$task) {
                abort(404, 'Task not found');
            }

            // Sử dụng Query Builder để delete task
            DB::table('tasks')->where('id', $id)->delete();

            return redirect()
                ->route('tasks.index')
                ->with('success', 'Task đã được xóa thành công!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi xóa task: ' . $e->getMessage());
        }
    }

    /**
     * Get tasks with user data using Query Builder
     * API endpoint to demonstrate Query Builder joins
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTasksWithUsers()
    {
        // Sử dụng Query Builder với JOIN để lấy tasks kèm thông tin users
        $tasks = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select(
                'tasks.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                DB::raw('CONCAT(users.first_name, " ", users.last_name) as user_full_name')
            )
            ->orderBy('tasks.created_at', 'desc')
            ->get();

        // Get additional statistics using Query Builder
        $stats = DB::table('tasks')
            ->select(
                DB::raw('COUNT(*) as total_tasks'),
                DB::raw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_tasks'),
                DB::raw('COUNT(CASE WHEN status = "in_progress" THEN 1 END) as in_progress_tasks'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed_tasks'),
                DB::raw('AVG(estimated_hours) as avg_estimated_hours'),
                DB::raw('AVG(actual_hours) as avg_actual_hours')
            )
            ->first();

        return response()->json([
            'message' => 'Tasks retrieved successfully with Query Builder',
            'data' => $tasks,
            'stats' => $stats,
            'meta' => [
                'total_tasks' => $tasks->count(),
                'using' => 'Query Builder with JOIN'
            ]
        ]);
    }

    /**
     * Get task statistics by user using Query Builder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaskStatsByUser()
    {
        // Sử dụng Query Builder để lấy thống kê tasks theo user
        $userStats = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                DB::raw('COUNT(tasks.id) as total_tasks'),
                DB::raw('COUNT(CASE WHEN tasks.status = "completed" THEN 1 END) as completed_tasks'),
                DB::raw('COUNT(CASE WHEN tasks.status = "pending" THEN 1 END) as pending_tasks'),
                DB::raw('COUNT(CASE WHEN tasks.status = "in_progress" THEN 1 END) as in_progress_tasks'),
                DB::raw('AVG(tasks.estimated_hours) as avg_estimated_hours'),
                DB::raw('SUM(tasks.actual_hours) as total_actual_hours')
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email')
            ->orderBy('total_tasks', 'desc')
            ->get();

        return response()->json([
            'message' => 'Task statistics by user retrieved successfully',
            'data' => $userStats,
            'meta' => [
                'total_users_with_tasks' => $userStats->count(),
                'using' => 'Query Builder with GROUP BY and aggregation functions'
            ]
        ]);
    }
}
