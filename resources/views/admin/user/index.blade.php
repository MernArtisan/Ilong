@extends('admin.layouts.master')
@section('title', 'Customer List')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">Customer</h6>
                </div>
                <div class="ms-auto"><a href="{{ route('admin.customer.create') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"><i
                            class="bx bxs-plus-square"></i>Add New User</a></div>
            </div>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                {{-- <th>Role</th>
                                <th>Phone</th> --}}
                                <th>State / City</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        @if ($user->image != null)
                                            <img src="{{ asset('profile_image/' . $user->image) }}" alt="Profile Image"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('default.png') }}" alt="Default Profile Image"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        @endif
                                    </td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->country }}</td>
                                    {{-- <td>{{ $user->role }}</td>
                                    <td>{{ $user->phone }}</td> --}}
                                    <td>{{ $user->state_city }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{ route('admin.customer.show', $user->id) }}" class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye text-white">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>

                                            <a href="{{ route('admin.customer.edit', $user->id) }}" class="ms-1">
                                                <i class="fas fa-pencil-alt text-white" style="font-size: 18px;"></i>
                                            </a>

                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('admin.customer.destroy', $user->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <a href="javascript:void(0);" class="ms-1"
                                                onclick="confirmDelete({{ $user->id }})">
                                                <i class='bx bxs-trash'></i>
                                            </a>


                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                {{-- <th>Role</th>
                                <th>Phone</th> --}}
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
