<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     * Using Eloquent ORM with eager loading
     *
     * @return View
     */
    public function index(Request $request): View
    {
        // Sử dụng Eloquent ORM với eager loading
        $query = User::with(['tasks', 'roles']);

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Order by newest first
        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Count statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
        ];
        
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Users Management', 'url' => '#']
        ];

        return view('users.index', compact('users', 'breadcrumbs', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function create(): View
    {
        $roles = Role::all();
        
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Users Management', 'url' => route('users.index')],
            ['title' => 'Create User', 'url' => '#']
        ];

        return view('users.create', compact('roles', 'breadcrumbs'));
    }

    /**
     * Store a newly created user in storage.
     * Using Eloquent ORM
     *
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            // Sử dụng Eloquent ORM để tạo user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Sync roles if provided
            if ($request->has('role_ids')) {
                $user->roles()->sync($request->role_ids);
            }

            return redirect()
                ->route('users.show', $user)
                ->with('success', 'User đã được tạo thành công!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     * Using Eloquent ORM with eager loading
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user): View
    {
        // Sử dụng Eloquent ORM với eager loading
        $user->load(['tasks' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }, 'roles']);

        // Load additional stats
        $stats = [
            'total_tasks' => $user->tasks()->count(),
            'completed_tasks' => $user->tasks()->where('status', 'completed')->count(),
            'pending_tasks' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
        ];
        
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Users Management', 'url' => route('users.index')],
            ['title' => 'User Detail', 'url' => '#']
        ];

        return view('users.show', compact('user', 'breadcrumbs', 'stats'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Users Management', 'url' => route('users.index')],
            ['title' => 'Edit User', 'url' => '#']
        ];

        return view('users.edit', compact('user', 'roles', 'userRoles', 'breadcrumbs'));
    }

    /**
     * Update the specified user in storage.
     * Using Eloquent ORM
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            // Prepare data for update
            $data = $request->only([
                'first_name', 'last_name', 'email', 'username', 'is_active'
            ]);

            // Hash password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Sử dụng Eloquent ORM để cập nhật user
            $user->update($data);

            // Sync roles if provided
            if ($request->has('role_ids')) {
                $user->roles()->sync($request->role_ids);
            }

            return redirect()
                ->route('users.show', $user)
                ->with('success', 'User đã được cập nhật thành công!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     * Using Eloquent ORM
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            // Detach roles first
            $user->roles()->detach();
            
            // Delete associated tasks (or you might want to reassign them)
            $user->tasks()->delete();
            
            // Delete the user
            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'User đã được xóa thành công!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi xóa user: ' . $e->getMessage());
        }
    }

    /**
     * Search and filter users
     * Using Eloquent ORM
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function search(Request $request): RedirectResponse
    {
        $searchParams = $request->only(['search', 'status']);
        
        return redirect()->route('users.index', $searchParams);
    }

    /**
     * Get users with their related data for API
     * Using Eloquent ORM with eager loading
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersWithRelations()
    {
        // Sử dụng Eloquent ORM với eager loading để lấy users kèm relations
        $users = User::with(['tasks', 'roles'])
            ->withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->get();

        return response()->json([
            'message' => 'Users retrieved successfully with eager loading',
            'data' => $users,
            'meta' => [
                'total_users' => $users->count(),
                'using' => 'Eloquent ORM with eager loading'
            ]
        ]);
    }
}