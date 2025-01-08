@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Manager Users</h1>

    <!-- Thêm User -->
    <form method="POST" action="{{ route('users.store') }}" class="mb-4">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter user name" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Enter user email" required>
        </div>
        <button type="submit" class="btn btn-success">Add User</button>
    </form>

    <!-- Danh sách Users -->
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Sửa User -->
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>

                        <!-- Xóa User -->
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
