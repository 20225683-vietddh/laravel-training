<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // For now, just return the view with static data
        // In the future, you can add: $users = User::with(['tasks', 'roles'])->paginate(10);
        
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Users Management', 'url' => '#']
        ];

        return view('users.index', compact('breadcrumbs'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // This will be implemented later
        return redirect()->route('users.index')->with('info', 'Chức năng tạo mới đang được phát triển!');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // This will be implemented later
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // For demo purposes, we'll show static data
        // In the future: $user = User::with(['tasks', 'roles'])->findOrFail($id);
        
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('users.index')],
            ['title' => 'Users Management', 'url' => route('users.index')],
            ['title' => 'User Detail', 'url' => '#']
        ];

        // Static user data for demo
        $user = (object) [
            'id' => $id,
            'first_name' => 'Nguyễn',
            'last_name' => 'Văn A',
            'full_name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'username' => 'nguyenvana',
            'is_active' => true,
            'created_at' => '2023-12-15 10:30:00',
            'last_login_at' => now()
        ];

        return view('users.show', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // This will be implemented later
        return redirect()->route('users.show', $id)->with('info', 'Chức năng chỉnh sửa đang được phát triển!');
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // This will be implemented later
        return redirect()->route('users.show', $id)->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // This will be implemented later
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Search and filter users
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // This will implement the search/filter functionality
        $searchTerm = $request->get('search');
        $status = $request->get('status');
        
        // For now, redirect back with search info
        return redirect()->route('users.index')->with('info', "Tìm kiếm: '{$searchTerm}' với trạng thái: '{$status}'");
    }
}