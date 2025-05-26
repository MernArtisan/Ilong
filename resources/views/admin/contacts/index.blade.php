@extends('admin.layouts.master')
@section('title', 'User List')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">Customer</h6>
                </div>
            </div>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">ID</th>
                                <th width="10%">Name</th>
                                <th width="20%">Email</th>
                                <th width="59%">Message</th>
                                <th width="59%">Seen</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            @foreach ($contact as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->full_name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->message }}</td>
                                    <td>
                                        @if ($user->seen  == 1)
                                            <span class="badge bg-danger ms-2">Seen</span>
                                        @elseif ($user->seen == 0)
                                            <span class="badge bg-success ms-2">New</span>
                                        @endif
                                    </td>                                    
                                    <td class="text-center">
                                        <div class="d-flex order-actions">
                                            <a href="{{ route('admin.contactShow', $user->id) }}" class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye text-white">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th width="1%">ID</th>
                                <th width="10%">Name</th>
                                <th width="20%">Email</th>
                                <th width="59%">Message</th>
                                <th width="5%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
