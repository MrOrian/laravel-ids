@extends('adminlte::page')

@section('title', 'User Management')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css">
    
@stop
@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Search Form -->
            <div class="mb-3">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search users" value="{{ request('search') }}">
                        <button type="button" id="searchButton" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>

            <!-- Add Button -->
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-plus"></i> Add User
            </button>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                        <!-- Edit Button -->
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }} <!-- Tự động hiển thị phân trang -->
            </div>
            <!-- Pagination -->
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <small class="text-danger" id="error-name"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            <small class="text-danger" id="error-email"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <small class="text-danger" id="error-password"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.update', 'user_id') }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_password">Password</label>
                            <input type="password" class="form-control" name="password" id="edit_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('js')
<script>
    //AJAX SEARCH
    $(document).ready(function () {
        $('#searchButton').on('click', function () {
            var query = $('#searchInput').val();

            $.ajax({
                url: "{{ route('users.searchByName') }}",
                type: "GET",
                data: { search: query },
                success: function (response) {
                    if (response.success && response.users.data.length > 0) {
                        var usersHtml = '';
                        response.users.data.forEach(function (user) {
                            usersHtml += `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-user" data-id="${user.id}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('table tbody').html(usersHtml);
                    } else {
                        $('table tbody').html('<tr><td colspan="4" class="text-center">No users found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong!');
                }
            });
        });
    });

//------------------------------------------------------------------//

    //AJAX ADD
    $(document).ready(function () {
        $('#addUserForm').off('submit').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        alert(response.message);

                        $('#addUserModal').modal('hide');

                        let newUserRow = `
                            <tr>
                                <td>${response.user.id}</td>
                                <td>${response.user.name}</td>
                                <td>${response.user.email}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="${response.user.id}" data-name="${response.user.name}" data-email="${response.user.email}">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>
                                    <form action="/users/${response.user.id}" method="POST" style="display:inline;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;

                        $('table tbody').append(newUserRow);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        let errorMessage = 'Validation Errors:\n';
                        $.each(errors, function (key, value) {
                            errorMessage += '- ' + value[0] + '\n';
                        });
                        alert(errorMessage);
                    } else {
                        alert('Something went wrong!');
                    }
                }
            });
        });
    });
//------------------------------------------------------------------//

    //AJAX EDIT
    $(document).ready(function () {
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id');
        var userName = button.data('name');
        var userEmail = button.data('email');

        var modal = $(this);
        modal.find('#edit_name').val(userName);
        modal.find('#edit_email').val(userEmail);

        var formAction = '{{ route('users.update', ':id') }}';
        formAction = formAction.replace(':id', userId);
        modal.find('form').attr('action', formAction);
    });

    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function (response) {
                console.log(response);

                if (response.success && response.user) {
                    alert(response.message);
                    $('#editUserModal').modal('hide');

                    let updatedRow = `
                        <tr>
                            <td>${response.user.id}</td>
                            <td>${response.user.name}</td>
                            <td>${response.user.email}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal"
                                    data-id="${response.user.id}" data-name="${response.user.name}" data-email="${response.user.email}">
                                    <i class="fas fa-pen"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-user" data-id="${response.user.id}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    `;

                    let row = $('table tbody').find(`button[data-id="${response.user.id}"]`).closest('tr');
                    if (row.length) {
                        row.replaceWith(updatedRow);
                    } else {
                        $('table tbody').append(updatedRow);
                    }
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                let errorMessage = 'Something went wrong!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    // Xử lý lỗi validation
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                }
                alert(errorMessage);
            }
        });
    });
//------------------------------------------------------------------//
    //AJAX DELETE
    $(document).on('click', '.delete-user', function (e) {
        e.preventDefault();

        var userId = $(this).data('id');
        var deleteUrl = '/users/' + userId;

        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.success);
                        $('table tbody').find(`button[data-id="${userId}"]`).closest('tr').remove();
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong!');
                }
            });
        }
    });


});
</script>
@stop