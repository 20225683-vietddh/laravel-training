@extends('layouts.app')

@section('title', 'Users Management')
@section('page_title', 'Users Management')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Danh sách người dùng</h4>
                        <p class="card-category">Quản lý tất cả người dùng trong hệ thống</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-fill" onclick="createUser()">
                            <i class="nc-icon nc-simple-add"></i> Thêm người dùng mới
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Search và Filter -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Tìm kiếm theo tên, email..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="statusFilter">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info btn-fill" onclick="filterUsers()">
                            <i class="nc-icon nc-zoom-split"></i> Lọc
                        </button>
                        <button type="button" class="btn btn-secondary btn-simple" onclick="resetFilter()">
                            <i class="nc-icon nc-refresh-69"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Bảng Users -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Avatar</th>
                                <th width="20%">Họ tên</th>
                                <th width="20%">Email</th>
                                <th width="10%">Username</th>
                                <th width="10%">Trạng thái</th>
                                <th width="10%">Roles</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Sample Data - sẽ được thay thế bằng dữ liệu thực -->
                            <tr onclick="viewUserDetail(1)" style="cursor: pointer;">
                                <td>1</td>
                                <td>
                                    <div class="avatar">
                                        <img src="{{ asset('img/default-avatar.png') }}" alt="avatar" class="img-circle img-no-padding img-responsive">
                                    </div>
                                </td>
                                <td>
                                    <strong>Nguyễn Văn A</strong><br>
                                    <small class="text-muted">Tham gia: 15/12/2023</small>
                                </td>
                                <td>nguyenvana@example.com</td>
                                <td>@nguyenvana</td>
                                <td>
                                    <span class="badge badge-success">Hoạt động</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">Admin</span>
                                    <span class="badge badge-secondary">User</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-simple btn-xs" onclick="event.stopPropagation(); viewUser(1)" title="Xem chi tiết">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-simple btn-xs" onclick="event.stopPropagation(); editUser(1)" title="Chỉnh sửa">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="event.stopPropagation(); deleteUser(1)" title="Xóa">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr onclick="viewUserDetail(2)" style="cursor: pointer;">
                                <td>2</td>
                                <td>
                                    <div class="avatar">
                                        <img src="{{ asset('img/default-avatar.png') }}" alt="avatar" class="img-circle img-no-padding img-responsive">
                                    </div>
                                </td>
                                <td>
                                    <strong>Trần Thị B</strong><br>
                                    <small class="text-muted">Tham gia: 20/12/2023</small>
                                </td>
                                <td>tranthib@example.com</td>
                                <td>@tranthib</td>
                                <td>
                                    <span class="badge badge-warning">Tạm khóa</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">User</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-simple btn-xs" onclick="event.stopPropagation(); viewUser(2)" title="Xem chi tiết">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-simple btn-xs" onclick="event.stopPropagation(); editUser(2)" title="Chỉnh sửa">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="event.stopPropagation(); deleteUser(2)" title="Xóa">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr onclick="viewUserDetail(3)" style="cursor: pointer;">
                                <td>3</td>
                                <td>
                                    <div class="avatar">
                                        <img src="{{ asset('img/default-avatar.png') }}" alt="avatar" class="img-circle img-no-padding img-responsive">
                                    </div>
                                </td>
                                <td>
                                    <strong>Lê Văn C</strong><br>
                                    <small class="text-muted">Tham gia: 25/12/2023</small>
                                </td>
                                <td>levanc@example.com</td>
                                <td>@levanc</td>
                                <td>
                                    <span class="badge badge-success">Hoạt động</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">User</span>
                                    <span class="badge badge-primary">Editor</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-simple btn-xs" onclick="event.stopPropagation(); viewUser(3)" title="Xem chi tiết">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-simple btn-xs" onclick="event.stopPropagation(); editUser(3)" title="Chỉnh sửa">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="event.stopPropagation(); deleteUser(3)" title="Xóa">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted">Hiển thị 1-3 của 3 bản ghi</p>
                    </div>
                    <div class="col-md-6">
                        <nav>
                            <ul class="pagination justify-content-end">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Trước</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Sau</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for User Actions -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Thông tin người dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    function viewUserDetail(userId) {
        // Redirect to user detail page
        window.location.href = `/users/${userId}`;
    }

    function createUser() {
        alert('Chức năng "Tạo mới" sẽ được phát triển trong tương lai!');
        // Có thể redirect đến form tạo user hoặc mở modal
    }

    function viewUser(userId) {
        alert(`Xem chi tiết user ID: ${userId}`);
        // Load user details in modal or redirect
    }

    function editUser(userId) {
        alert(`Chỉnh sửa user ID: ${userId}`);
        // Redirect to edit form or load in modal
    }

    function deleteUser(userId) {
        if(confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
            alert(`Xóa user ID: ${userId}`);
            // Send delete request
        }
    }

    function filterUsers() {
        const searchTerm = document.getElementById('searchInput').value;
        const statusFilter = document.getElementById('statusFilter').value;
        alert(`Lọc với: "${searchTerm}" và trạng thái: "${statusFilter}"`);
        // Implement filtering logic
    }

    function resetFilter() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        // Reset table data
    }

    // Table row hover effect
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('#usersTableBody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection