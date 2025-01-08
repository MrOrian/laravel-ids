<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    // Hiển thị danh sách user
    public function index()
    {
        $users = User::paginate(3);
        return view('users.index', compact('users'));
    }

    // Thêm user mới
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Mã hóa mật khẩu nhập vào
        ]);
    
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);  // Lấy người dùng theo ID
        return view('users.edit', compact('user'));  // Trả về view với thông tin người dùng
    }

    // Cập nhật thông tin người dùng
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);  // Lấy người dùng theo ID

        // Cập nhật thông tin người dùng
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }
    // Xóa user
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
