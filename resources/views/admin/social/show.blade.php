@extends('admin.layouts.master')
@section('title', 'User Show')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User {{ $user->first_name }}</div>
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
                        @if ($user->posts)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Posts</h5>
                                        <hr />
                                        <div class="accordion" id="accordionPosts">
                                            @forelse ($user->posts as $key => $post)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingPosts{{ $key }}">
                                                        <button
                                                            class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapsePosts{{ $key }}"
                                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapsePosts{{ $key }}">
                                                            Post #{{ $key + 1 }}: {{ $post->name ?? 'N/A' }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapsePosts{{ $key }}"
                                                        class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                        aria-labelledby="headingPosts{{ $key }}"
                                                        data-bs-parent="#accordionPosts">
                                                        <div class="accordion-body">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td><strong>Name:</strong></td>
                                                                    <td>{{ $post->name ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Description:</strong></td>
                                                                    <td>{{ $post->description ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Share:</strong></td>
                                                                    <td>{{ $post->share_count ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Likes:</strong></td>
                                                                    <td>{{ $post->likes->count() ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Comments:</strong></td>
                                                                    <td>{{ $post->comments->count() ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Image:</strong></td>
                                                                    @foreach ($post->images as $image)
                                                                        <td>
                                                                            @if (!empty($image->image_path))
                                                                                <img src="{{ asset('contentpost/' . $image->image_path) }}"
                                                                                    alt="Post" width="100"
                                                                                    height="100">
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button">
                                                            No posts found.
                                                        </button>
                                                    </h2>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-12">
                                <h4>No posts found</h4>
                            </div>
                        @endif

                        @if ($user->groups)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Join Group</h5>
                                        <hr />
                                        <div class="accordion" id="accordionGroups">
                                            @forelse ($user->groups as $key => $group)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingGroups{{ $key }}">
                                                        <button
                                                            class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseGroups{{ $key }}"
                                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapseGroups{{ $key }}">
                                                            Group #{{ $key + 1 }}: {{ $group->name ?? 'N/A' }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseGroups{{ $key }}"
                                                        class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                        aria-labelledby="headingGroups{{ $key }}"
                                                        data-bs-parent="#accordionGroups">
                                                        <div class="accordion-body">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td><strong>Name:</strong></td>
                                                                    <td>{{ $group->name ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Description:</strong></td>
                                                                    <td>{{ $group->description ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Share:</strong></td>
                                                                    <td>{{ $group->share_count ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Image:</strong></td>
                                                                    <td>
                                                                        @if (!empty($group->image))
                                                                            <img src="{{ asset('group_images/' . $group->image) }}"
                                                                                alt="Group" width="100"
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
                                                            No groups found.
                                                        </button>
                                                    </h2>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-12">
                                <h4>No groups found</h4>
                            </div>
                        @endif

                        @if ($user->createdGroups)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Create Group</h5>
                                        <hr />
                                        <div class="accordion" id="accordionCreatedGroups">
                                            @forelse ($user->createdGroups as $key => $group)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header"
                                                        id="headingCreatedGroups{{ $key }}">
                                                        <button
                                                            class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseCreatedGroups{{ $key }}"
                                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapseCreatedGroups{{ $key }}">
                                                            Group #{{ $key + 1 }}: {{ $group->name ?? 'N/A' }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseCreatedGroups{{ $key }}"
                                                        class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                        aria-labelledby="headingCreatedGroups{{ $key }}"
                                                        data-bs-parent="#accordionCreatedGroups">
                                                        <div class="accordion-body">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td><strong>Name:</strong></td>
                                                                    <td>{{ $group->name ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Description:</strong></td>
                                                                    <td>{{ $group->description ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Share:</strong></td>
                                                                    <td>{{ $group->share_count ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Image:</strong></td>
                                                                    <td>
                                                                        @if (!empty($group->image))
                                                                            <img src="{{ asset('group_images/' . $group->image) }}"
                                                                                alt="Group" width="100"
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
                                                            No created groups found.
                                                        </button>
                                                    </h2>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-12">
                                <h4>No created groups found</h4>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
