@extends('layouts.app')

@section('title', 'User Detail')
@section('page_title', 'Chi tiết người dùng')

@section('content')
<!-- User Profile Card -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Thông tin người dùng</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-fill">
                            <i class="nc-icon nc-minimal-left"></i> Quay lại danh sách
                        </a>
                        <button type="button" class="btn btn-warning btn-fill" onclick="editUserProfile()">
                            <i class="nc-icon nc-ruler-pencil"></i> Chỉnh sửa
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('img/default-avatar.png') }}" alt="avatar" class="img-circle img-no-padding img-responsive">
                        </div>
                        <h5 class="mt-3">Nguyễn Văn A</h5>
                        <p class="text-muted">@nguyenvana</p>
                        <span class="badge badge-success">Hoạt động</span>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Họ:</strong></label>
                                    <p>Nguyễn</p>
                                </div>
                                <div class="form-group">
                                    <label><strong>Tên:</strong></label>
                                    <p>Văn A</p>
                                </div>
                                <div class="form-group">
                                    <label><strong>Email:</strong></label>
                                    <p>nguyenvana@example.com</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Username:</strong></label>
                                    <p>nguyenvana</p>
                                </div>
                                <div class="form-group">
                                    <label><strong>Ngày tham gia:</strong></label>
                                    <p>15/12/2023</p>
                                </div>
                                <div class="form-group">
                                    <label><strong>Lần đăng nhập cuối:</strong></label>
                                    <p>{{ date('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thống kê nhanh</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 class="text-primary">5</h3>
                        <p>Tổng số Tasks</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <h4 class="text-success">3</h4>
                        <p><small>Hoàn thành</small></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <h4 class="text-warning">2</h4>
                        <p><small>Đang thực hiện</small></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="text-info">2</h4>
                        <p>Roles được gán</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Roles Section -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Roles của người dùng</h4>
                        <p class="card-category">Quản lý quyền và vai trò</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-sm" onclick="assignRole()">
                            <i class="nc-icon nc-simple-add"></i> Gán Role
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Mô tả</th>
                                <th>Ngày gán</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="badge badge-info">Admin</span>
                                </td>
                                <td>Quản trị viên hệ thống</td>
                                <td>15/12/2023</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="removeRole(1)" title="Xóa role">
                                        <i class="nc-icon nc-simple-remove"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">User</span>
                                </td>
                                <td>Người dùng cơ bản</td>
                                <td>15/12/2023</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="removeRole(2)" title="Xóa role">
                                        <i class="nc-icon nc-simple-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Tasks Section -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Tasks của người dùng</h4>
                        <p class="card-category">Danh sách công việc được gán</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-sm" onclick="createTask()">
                            <i class="nc-icon nc-simple-add"></i> Tạo Task
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Task Title</th>
                                <th>Trạng thái</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Thiết kế giao diện admin</strong><br>
                                    <small class="text-muted">Tạo giao diện quản trị cho hệ thống</small>
                                </td>
                                <td>
                                    <span class="badge badge-success">Hoàn thành</span>
                                </td>
                                <td>20/12/2023</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-simple btn-xs" onclick="viewTask(1)" title="Xem chi tiết">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-simple btn-xs" onclick="editTask(1)" title="Chỉnh sửa">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="deleteTask(1)" title="Xóa">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Phát triển API users</strong><br>
                                    <small class="text-muted">Tạo các endpoint API cho quản lý users</small>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Đang thực hiện</span>
                                </td>
                                <td>25/12/2023</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-simple btn-xs" onclick="viewTask(2)" title="Xem chi tiết">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-simple btn-xs" onclick="editTask(2)" title="Chỉnh sửa">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="deleteTask(2)" title="Xóa">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Viết tài liệu hướng dẫn</strong><br>
                                    <small class="text-muted">Tạo documentation cho dự án</small>
                                </td>
                                <td>
                                    <span class="badge badge-info">Chờ xử lý</span>
                                </td>
                                <td>30/12/2023</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-simple btn-xs" onclick="viewTask(3)" title="Xem chi tiết">
                                            <i class="nc-icon nc-zoom-split"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-simple btn-xs" onclick="editTask(3)" title="Chỉnh sửa">
                                            <i class="nc-icon nc-ruler-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple btn-xs" onclick="deleteTask(3)" title="Xóa">
                                            <i class="nc-icon nc-simple-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- View All Tasks Button -->
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-info btn-simple" onclick="viewAllTasks()">
                        Xem tất cả Tasks <i class="nc-icon nc-minimal-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Timeline -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Hoạt động gần đây</h4>
                <p class="card-category">Lịch sử hoạt động của người dùng</p>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Hoàn thành task "Thiết kế giao diện admin"</h6>
                            <p class="timeline-description">Task đã được đánh dấu hoàn thành với chất lượng tốt</p>
                            <small class="text-muted">2 giờ trước</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Được gán role "Admin"</h6>
                            <p class="timeline-description">Quyền quản trị viên đã được cấp cho người dùng</p>
                            <small class="text-muted">1 ngày trước</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Cập nhật thông tin profile</h6>
                            <p class="timeline-description">Thông tin cá nhân đã được cập nhật</p>
                            <small class="text-muted">3 ngày trước</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_css')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e3e3e3;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
        z-index: 1;
    }
    
    .timeline-content {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border-left: 3px solid #007bff;
    }
    
    .timeline-title {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .timeline-description {
        margin-bottom: 5px;
        color: #666;
    }
    
    .avatar-xl img {
        width: 100px;
        height: 100px;
    }
</style>
@endsection

@section('extra_js')
<script>
    function editUserProfile() {
        alert('Chỉnh sửa thông tin người dùng - chức năng sẽ được phát triển!');
    }

    // Role Management Functions
    function assignRole() {
        alert('Gán role mới cho người dùng - chức năng sẽ được phát triển!');
    }

    function removeRole(roleId) {
        if(confirm('Bạn có chắc chắn muốn xóa role này khỏi người dùng?')) {
            alert(`Xóa role ID: ${roleId}`);
        }
    }

    // Task Management Functions
    function createTask() {
        alert('Tạo task mới cho người dùng - chức năng sẽ được phát triển!');
    }

    function viewTask(taskId) {
        alert(`Xem chi tiết task ID: ${taskId}`);
    }

    function editTask(taskId) {
        alert(`Chỉnh sửa task ID: ${taskId}`);
    }

    function deleteTask(taskId) {
        if(confirm('Bạn có chắc chắn muốn xóa task này?')) {
            alert(`Xóa task ID: ${taskId}`);
        }
    }

    function viewAllTasks() {
        alert('Chuyển đến trang quản lý tất cả tasks của user');
    }
</script>
@endsection