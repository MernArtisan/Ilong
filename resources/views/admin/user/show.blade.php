@extends('admin.layouts.master')
@section('title', 'Customer Show')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Customer {{ $user->first_name }}</div>
                {{-- <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            {{ ucfirst($user->login_status) }}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                            <a class="dropdown-item {{ $user->login_status == 'approve' ? 'active' : '' }}"
                                href="javascript:void(0);"
                                onclick="changeStatus('approve', {{ $user->id }})">Approve</a>

                            <a class="dropdown-item {{ $user->login_status == 'block' ? 'active' : '' }}"
                                href="javascript:void(0);" onclick="changeStatus('block', {{ $user->id }})">Block</a>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        @if ($user->image != null)
                                            <img src="{{ asset('profile_image/' . $user->image) }}" alt="Admin"
                                                class="p-1" width="225"
                                                style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border: 4px solid #ccc;">
                                        @else
                                            <img src="{{ asset('default.png') }}" alt="Admin" class="p-1"
                                                width="225"
                                                style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border: 4px solid #ccc;">
                                        @endif

                                        <div class="mt-3">
                                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                                            <p class="mb-1">{{ $user->role }}</p>
                                            <p class="font-size-sm">{{ $user->country }} - {{ $user->state_city }}</p>
                                        </div>
                                    </div>
                                    {{-- <hr class="my-4" /> --}}
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Country</h6>
                                            <span class="text-white">{{ $user->country }}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">State/City</h6>
                                            <span class="text-white">{{ $user->state_city }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                value="{{ $user->first_name }} {{ $user->last_name }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $user->email }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $user->phone }}"
                                                readonly />
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Country</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{ $user->country }}" readonly/>
                                    </div>
                                </div> --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Created At</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                value="{{ $user->created_at->format('j M Y') }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Role</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $user->role }}"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Zip Code</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $user->zip }}"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Age</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $user->age ?? '' }}"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <a href="{{ route('admin.customer.edit', $user->id) }}"
                                            class="btn btn-info">Edit</a>
                                    </div>
                                    <div class="btn-group">
                                        <!-- Block button -->
                                        <button type="button" class="btn btn-danger me-2" 
                                            onclick="changeStatus('block', {{ $user->id }})"
                                            @if ($user->login_status == 'block') disabled @endif>
                                            Block
                                        </button>
                                    
                                        <!-- Approve button -->
                                        <button type="button" class="btn btn-success me-2" 
                                            onclick="changeStatus('approve', {{ $user->id }})"
                                            @if ($user->login_status == 'approve') disabled @endif>
                                            Approve
                                        </button>
                                    
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Children Information</h5>
                                    <hr />
                                    <div class="accordion" id="accordionExample">
                                        @forelse ($user->childrens as $key => $child)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $key }}">
                                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $key }}"
                                                        aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                        aria-controls="collapse{{ $key }}">
                                                        Child #{{ $key + 1 }}: {{ $child->name ?? 'N/A' }}
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $key }}"
                                                    class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                    aria-labelledby="heading{{ $key }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td><strong>Name:</strong></td>
                                                                <td>{{ $child->name ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Age:</strong></td>
                                                                <td>{{ $child->age ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Gender:</strong></td>
                                                                <td>{{ $child->gender ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Concern:</strong></td>
                                                                <td>
                                                                    @if (is_string($child->concern))
                                                                        @php $concern = json_decode($child->concern, true); @endphp
                                                                        @if (is_array($concern))
                                                                            {{ implode(', ', $concern) }}
                                                                        @else
                                                                            {{ $child->concern }}
                                                                        @endif
                                                                    @elseif(is_array($child->concern))
                                                                        {{ implode(', ', $child->concern) }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Interests:</strong></td>
                                                                <td>
                                                                    @if (is_string($child->interests))
                                                                        @php $interests = json_decode($child->interests, true); @endphp
                                                                        @if (is_array($interests))
                                                                            {{ implode(', ', $interests) }}
                                                                        @else
                                                                            {{ $child->interests }}
                                                                        @endif
                                                                    @elseif(is_array($child->interests))
                                                                        {{ implode(', ', $child->interests) }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Description:</strong></td>
                                                                <td>{{ $child->description ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Image:</strong></td>
                                                                <td>
                                                                    @if (!empty($child->image))
                                                                        <img src="{{ asset('ChildrenProfile/' . $child->image) }}"
                                                                            alt="Child Image" width="100"
                                                                            height="100">
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        @empty
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button">
                                                        No children found.
                                                    </button>
                                                </h2>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
