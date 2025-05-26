@extends('admin.layouts.master')
@section('title', 'User List')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">App Users</h6>
                </div>
                {{-- <div class="ms-auto"><a href="{{ route('admin.customer.create') }}"
                        class="btn btn-light radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New User</a></div> --}}
            </div>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Role</th>
                                <th>Create Group</th>
                                <th>Join Group</th>
                                <th>Post</th>
                                <th>State / City</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td>
                                        @if ($user->image != null)
                                            <img src="{{ asset('profile_image/' . $user->image) }}" alt="Profile Image"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('default.png') }}" alt="Default Profile Image"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->country }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($user->role) }}</span>
                                    </td>
                    
                                    <!-- Create Group Count with Color -->
                                    <td>
                                        <span class="badge {{ $user->createdGroups->count() > 0 ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $user->createdGroups->count() }}
                                        </span>
                                    </td>
                    
                                    <!-- Join Group Count with Color -->
                                    <td>
                                        <span class="badge {{ $user->groups->count() > 0 ? 'badge-warning' : 'badge-secondary' }}">
                                            {{ $user->groups->count() }}
                                        </span>
                                    </td>
                    
                                    <!-- Post Count with Color -->
                                    <td>
                                        <span class="badge {{ $user->posts->count() > 0 ? 'badge-primary' : 'badge-secondary' }}">
                                            {{ $user->posts->count() }}
                                        </span>
                                    </td>
                    
                                    <td>{{ $user->state_city }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye text-white">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    
                        <tfoot>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Role</th>
                                <th>Create Group</th>
                                <th>Join Group</th>
                                <th>Post</th>
                                <th>State / City</th>
                                <th width="10%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
