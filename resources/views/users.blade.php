@extends('layouts.app')

@section('title', 'Users List | Money Portal')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <!-- Page Body -->
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between">

                                <div class="d-flex justify-content-between w-100">
                                    <a class="contactapp-title link-dark">
                                        <h1>Users List</h1>
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary flex-shrink-0 d-lg-inline-block d-none"
                                        data-bs-toggle="modal" data-bs-target="#add_new_contact">+ Create New</button>
                                </div>

                            </div>

                        </header>
                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error . ',' }}
                                        @endforeach
                                    </div>
                                @endif
                                <div class="contact-list-view">
                                    <table id="EmpTable" class="table nowrap w-100 mb-5">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Position</th>
                                                <th>Date Created</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($users as $users)
                                                @if ($users->id != Auth::user()->id)
                                                    <tr>
                                                        <td>
                                                            #{{ $users->users_id }}
                                                        </td>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <span
                                                                        class="d-block text-high-em">{{ $users->name }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $users->email }}</td>
                                                        <td>{{ $users->role }}</td>
                                                        <td>{{ $users->created_at }}</td>
                                                        <td>
                                                            @if ($users->status == 'Active')
                                                                <span class="badge badge-soft-success">Active</span>
                                                            @elseif($users->status == 'Deactive')
                                                                <span class="badge badge-soft-danger">Deactive</span>
                                                            @endif

                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-flex">
                                                                    <a data-emp-id="{{ $users->id }}"
                                                                        class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover edit-users-btn"
                                                                        data-bs-toggle="modal" data-bs-target="#edit_emp"
                                                                        title="Edit">
                                                                        <span class="icon">
                                                                            <span class="feather-icon"><i
                                                                                    data-feather="edit"></i></span>
                                                                        </span>
                                                                    </a>

                                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                                        data-bs-toggle="tooltip" data-placement="top"
                                                                        title="" data-bs-original-title="Delete"
                                                                        href="#"><span class="icon"><span
                                                                                class="feather-icon"><i
                                                                                    data-feather="trash"></i></span></span></a>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Info -->
                    <div id="add_new_contact" class="modal fade add-new-contact" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('userss.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="mb-5">Create user</h5>

                                        <div class="row gx-3">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Full Name</label>
                                                    <input class="form-control" type="text" name="name"
                                                        placeholder="Full Name" required />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                        placeholder="Email" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Department</label>
                                                    <select class="form-select" name="role" required>
                                                        <option selected="">--</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Sales Manager">Sales Manager</option>
                                                        <option value="Sales">Sales</option>
                                                        <option value="Accounts Manager">Accounts Manager</option>
                                                        <option value="Accounts">Accounts</option>
                                                        <option value="Operations Manager">Operations Manager</option>
                                                        <option value="Operations">Operations</option>
                                                        <option value="Post Sales Manager">Post Sales Manager</option>
                                                        <option value="Post Sales">Post Sales</option>
                                                        <option value="Delivery Manager">Delivery Manager</option>
                                                        <option value="Delivery">Delivery</option>
                                                        <option value="HR">HR</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Password</label>
                                                    <input class="form-control" type="text" name="password"
                                                        placeholder="Set New Password" required />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer align-items-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary">Create
                                            users</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="edit_emp" class="modal fade add-new-contact" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('users.update') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="mb-5">Update user</h5>

                                        <div class="row gx-3">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Full Name</label>
                                                    <input class="form-control" type="text" id="emp_name"
                                                        name="name" placeholder="Full Name" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                        id="emp_email" placeholder="Email" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Department</label>
                                                    <select class="form-select" name="role" id="emp_position"
                                                        required>
                                                        <option selected="">--</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Sales Manager">Sales Manager</option>
                                                        <option value="Sales">Sales</option>
                                                        <option value="Accounts Manager">Accounts Manager</option>
                                                        <option value="Accounts">Accounts</option>
                                                        <option value="Operations Manager">Operations Manager</option>
                                                        <option value="Operations">Operations</option>
                                                        <option value="Post Sales Manager">Post Sales Manager</option>
                                                        <option value="Post Sales">Post Sales</option>
                                                        <option value="Delivery Manager">Delivery Manager</option>
                                                        <option value="Delivery">Delivery</option>
                                                        <option value="HR">HR</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">New Password</label>
                                                    <input class="form-control" type="text" name="password"
                                                        placeholder="Set New Password" id="emp_password" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" name="status" id="emp_status" required>
                                                        <option value="Active">Active</option>
                                                        <option value="Deactive">Deactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer align-items-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary">Update
                                            user</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Edit Info -->

                </div>
            </div>
        </div>
        <!-- /Page Body -->
    </div>
@endsection
