<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
</head>
<body>
    <x-sidebar active="users" />

    <div class="main-content">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1>User Management</h1>
                    <p>Manage all user accounts and permissions</p>
                </div>
                <div class="actions-bar">
                    <button class="btn btn-primary" onclick="openAddUserModal()">
                        <i class="fas fa-plus"></i>
                        Add User
                    </button>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Content Card -->
            <div class="content-card">
                <!-- Pending Users Table -->
                <div class="table-section">
                    <div class="card-header">
                        <h2>Pending Users</h2>
                    </div>

                    <div class="card-body">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingUsers ?? [] as $user)
                                    @php
                                        $fullName = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');
                                        if (trim($fullName) === '') {
                                            $fullName = $user->username ?? $user->email ?? 'User';
                                        }
                                        $initials = strtoupper(substr($fullName, 0, 1));
                                        $status = $user->status ?? 'active';
                                        $role = $user->role ?? 'student';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    @if($user && isset($user->avatar))
                                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $fullName }}">
                                                    @else
                                                        {{ $initials }}
                                                    @endif
                                                </div>
                                                <div class="user-details">
                                                    <div class="user-name">{{ $fullName }}</div>
                                                    <div class="user-email">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="role-badge role-{{ $role }}">
                                                {{ ucfirst($role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $status }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon btn-icon-approve" title="Approve" onclick="approveUser({{ $user->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-reject" title="Reject" onclick="rejectUser({{ $user->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i class="fas fa-user-clock"></i>
                                                </div>
                                                <h3>No Pending Users</h3>
                                                <p>All users have been processed</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- All Users Content Card -->
            <div class="content-card">
                <!-- All Users Table -->
                <div class="table-section">
                    <div class="card-header">
                        <h2>All Users</h2>
                    <div class="actions-bar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search users..." id="searchInput">
                        </div>
                        <select class="filter-select" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                        <select class="filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users ?? [] as $user)
                                @php
                                    $fullName = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');
                                    if (trim($fullName) === '') {
                                        $fullName = $user->username ?? $user->email ?? 'User';
                                    }
                                    $initials = strtoupper(substr($fullName, 0, 1));
                                    $status = $user->status ?? 'active';
                                    $role = $user->role ?? 'student';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                @if($user && isset($user->avatar))
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $fullName }}">
                                                @else
                                                    {{ $initials }}
                                                @endif
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">{{ $fullName }}</div>
                                                <div class="user-email">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role-badge role-{{ $role }}">
                                            {{ ucfirst($role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $status }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon btn-icon-view" title="View" onclick="viewUser({{ $user->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon btn-icon-edit" title="Edit" onclick="editUser({{ $user->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-icon-delete" title="Delete" onclick="deleteUser({{ $user->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <h3>No Users Found</h3>
                                            <p>Get started by adding your first user</p>
                                            <a href="#" class="btn btn-primary">
                                                <i class="fas fa-plus"></i>
                                                Add User
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($users) && count($users ?? []) > 0)
                    <div class="pagination">
                        <div class="pagination-info">
                            Showing 1 to {{ count($users ?? []) }} of {{ count($users ?? []) }} entries
                        </div>
                        <div class="pagination-links">
                            <a href="#" class="disabled">&laquo;</a>
                            <a href="#" class="active">1</a>
                            <a href="#">&raquo;</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div id="viewModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>User Details</h3>
                <button class="modal-close" onclick="closeModal('viewModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- User details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('viewModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit User</h3>
                <button class="modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="editFirstName">First Name</label>
                        <input type="text" class="form-input" id="editFirstName" name="first_name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editLastName">Last Name</label>
                        <input type="text" class="form-input" id="editLastName" name="last_name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editEmail">Email</label>
                        <input type="email" class="form-input" id="editEmail" name="email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editRole">Role</label>
                        <select class="form-select" id="editRole" name="role">
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editStatus">Status</label>
                        <select class="form-select" id="editStatus" name="status">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Delete</h3>
                <button class="modal-close" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New User</h3>
                <button class="modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addUserForm" onsubmit="handleAddUser(event)">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="addFirstName">First Name</label>
                        <input type="text" class="form-input" id="addFirstName" name="first_name" required>
                        <span class="form-error" id="addFirstNameError"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="addLastName">Last Name</label>
                        <input type="text" class="form-input" id="addLastName" name="last_name" required>
                        <span class="form-error" id="addLastNameError"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="addEmail">Email</label>
                        <input type="email" class="form-input" id="addEmail" name="email" required>
                        <span class="form-error" id="addEmailError"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="addPassword">Password</label>
                        <input type="password" class="form-input" id="addPassword" name="password" required minlength="8">
                        <span class="form-error" id="addPasswordError"></span>
                    </div>
                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="addRole">Role</label>
                            <select class="form-select" id="addRole" name="role" required>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="addStatus">Status</label>
                            <select class="form-select" id="addStatus" name="status" required>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.users-table tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('roleFilter')?.addEventListener('change', filterTable);
        document.getElementById('statusFilter')?.addEventListener('change', filterTable);

        function filterTable() {
            const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            
            document.querySelectorAll('.users-table tbody tr').forEach(row => {
                const role = row.querySelector('.role-badge')?.textContent.toLowerCase() || '';
                const status = row.querySelector('.status-badge')?.textContent.toLowerCase() || '';
                
                const roleMatch = !roleFilter || role.includes(roleFilter);
                const statusMatch = !statusFilter || status.includes(statusFilter);
                
                row.style.display = roleMatch && statusMatch ? '' : 'none';
            });
        }

        // Modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function viewUser(userId) {
            // Fetch user details and populate modal
            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(user => {
                    const fullName = (user.first_name || '') + ' ' + (user.last_name || '');
                    const modalBody = document.getElementById('viewModalBody');
                    modalBody.innerHTML = `
                        <div class="user-info" style="margin-bottom: 1.5rem;">
                            <div class="user-avatar" style="width: 60px; height: 60px; font-size: 20px;">
                                ${user.avatar ? `<img src="/storage/${user.avatar}" alt="${fullName}">` : fullName.charAt(0)}
                            </div>
                            <div class="user-details">
                                <div class="user-name" style="font-size: 1.125rem;">${fullName || 'User'}</div>
                                <div class="user-email">${user.email || ''}</div>
                            </div>
                        </div>
                        <div style="display: grid; gap: 1rem;">
                            <div>
                                <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-600); text-transform: uppercase;">Role</label>
                                <div style="font-weight: 600; color: var(--gray-800);">${(user.role || 'student').charAt(0).toUpperCase() + (user.role || 'student').slice(1)}</div>
                            </div>
                            <div>
                                <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-600); text-transform: uppercase;">Status</label>
                                <div style="font-weight: 600; color: var(--gray-800);">${(user.status || 'active').charAt(0).toUpperCase() + (user.status || 'active').slice(1)}</div>
                            </div>
                            <div>
                                <label style="font-size: 0.75rem; font-weight: 600; color: var(--gray-600); text-transform: uppercase;">Joined Date</label>
                                <div style="font-weight: 600; color: var(--gray-800);">${user.created_at ? new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A'}</div>
                            </div>
                        </div>
                    `;
                    document.getElementById('viewModal').style.display = 'flex';
                })
                .catch(error => console.error('Error:', error));
        }

        function editUser(userId) {
            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('editFirstName').value = user.first_name || '';
                    document.getElementById('editLastName').value = user.last_name || '';
                    document.getElementById('editEmail').value = user.email || '';
                    document.getElementById('editRole').value = user.role || 'student';
                    document.getElementById('editStatus').value = user.status || 'active';
                    document.getElementById('editUserForm').action = `/admin/users/${userId}`;
                    document.getElementById('editModal').style.display = 'flex';
                })
                .catch(error => console.error('Error:', error));
        }

        function deleteUser(userId) {
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function approveUser(userId) {
            if (confirm('Are you sure you want to approve this user?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}/approve`;
                form.innerHTML = `
                    @csrf
                    @method('PATCH')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function rejectUser(userId) {
            if (confirm('Are you sure you want to reject this user? This action will delete the user.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}/reject`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function openAddUserModal() {
            document.getElementById('addModal').style.display = 'flex';
        }

        function handleAddUser(event) {
            event.preventDefault();
            
            const form = document.getElementById('addUserForm');
            const formData = new FormData(form);
            
            // Clear previous errors
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
            document.querySelectorAll('.form-input, .form-select').forEach(el => el.style.borderColor = '');
            
            fetch('{{ route('admin.users.store.api') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('addModal');
                    form.reset();
                    // Reload the page to show the new user
                    window.location.reload();
                } else {
                    // Display validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(field + 'Error');
                            const inputElement = document.getElementById('add' + field.charAt(0).toUpperCase() + field.slice(1));
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                            }
                            if (inputElement) {
                                inputElement.style.borderColor = 'var(--error)';
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        // Close modals on outside click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });

        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay').forEach(modal => {
                    modal.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>
