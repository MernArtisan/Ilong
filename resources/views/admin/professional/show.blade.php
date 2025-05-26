@extends('admin.layouts.master')
@section('title', 'Professional Show ' . $professional->first_name)
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Proffesional {{ $professional->first_name }}
                    {{ $professional->last_name }}
                </div>
                {{-- <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            {{ ucfirst($professional->login_status) }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                            <a class="dropdown-item {{ $professional->login_status == 'approve' ? 'active' : '' }}"
                                href="javascript:void(0);"
                                onclick="changeStatus('approve', {{ $professional->id }})">Approve</a>
                            <a class="dropdown-item {{ $professional->login_status == 'block' ? 'active' : '' }}"
                                href="javascript:void(0);"
                                onclick="changeStatus('block', {{ $professional->id }})">Block</a>
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
                                        <img src="{{ asset('profile_image/' . $professional->image) }}" alt="Admin"
                                            width="225" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border: 4px solid #ccc;">
                                        <div class="mt-3">
                                            <h4>{{ $professional->first_name ?? '' }} {{ $professional->last_name ?? '' }}</h4>
                                            <p class="mb-1">{{ $professional->role ?? '' }}</p>
                                            <p class="font-size-sm">{{ $professional->country ?? '' }} -
                                                {{ $professional->state_city ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Country</h6>
                                            <span class="text-white">{{ $professional->country ?? ''}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">State/City</h6>
                                            <span class="text-white">{{ $professional->state_city ?? ''}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Total Appointment Earning</h6>
                                            <span class="text-white">${{ number_format($totalEarnings, 2) }}</span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Total Nurturenest Profit</h6>
                                            <span class="text-white">${{ number_format($nurturenestProfit, 2) }}</span>
                                        </li>

                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Professional's Final Earning</h6>
                                            <span class="text-white">${{ number_format($finalEarnings, 2) }}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Total Paid Earning</h6>
                                            <span
                                                class="text-white">${{ number_format($paidEarningsAfterProfit, 2) }}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Edit Button at the Top -->
                                    <a href="{{route('admin.professionals.edit', $professional->id)}}" class="btn btn-info mb-3">Edit</a>
                        
                                    <!-- Fields -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $professional->first_name ?? '' }} {{ $professional->last_name ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $professional->email ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $professional->phone ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Created At</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $professional->created_at->format('j M Y') }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Role</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $professional->role ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Zip Code</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $professional->zip ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Hour Rate</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="${{ $professional->professionalProfile->hour_rate ?? '' }}" readonly />
                                        </div>
                                    </div>
                        
                                    <!-- View Other Details Button at the Bottom -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewOtherDetailsModal">View Other Details</button>

                                    <div class="btn-group">
                                        @if ($professional->login_status == 'approve')
                                            <button type="button" class="btn btn-danger"
                                                    onclick="changeStatus('block', {{ $professional->id }})">
                                                Block
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success"
                                                    onclick="changeStatus('approve', {{ $professional->id }})">
                                                Approve
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                          
                        <div class="modal fade" id="viewOtherDetailsModal" tabindex="-1" aria-labelledby="viewOtherDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewOtherDetailsModalLabel">Other Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Additional Details Content -->
                                        <p>Here are additional details about the professional:</p>
                                        
                                        <!-- Work Experience and Licenses in two columns -->
                                        <div class="row">
                                            <!-- Left column for Work Experience -->
                                            <div class="col-md-6">
                                                <h6>Work Experience</h6>
                                                @if($professional->experiences->isNotEmpty())
                                                    <ul>
                                                        @foreach($professional->experiences as $experience)
                                                            <li>
                                                                <strong>{{ $experience->job_title }}</strong> at <em>{{ $experience->company_name }}</em><br>
                                                                From: {{ $experience->from }} To: {{ $experience->to }}<br>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p>No work experience available.</p>
                                                @endif
                                            </div>
                        
                                            <!-- Right column for Licenses -->
                                            <div class="col-md-6">
                                                <h6>Licenses</h6>
                                                @if($professional->licenses->isNotEmpty())
                                                    <ul>
                                                        @foreach($professional->licenses as $license)
                                                            <li>
                                                                <strong>{{ $license->license_name }}</strong> (License ID: {{ $license->license_id }})<br>
                                                                From: {{ $license->from }} To: {{ $license->to }}<br>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p>No licenses available.</p>
                                                @endif
                                            </div>
                                        </div>
                        
                                        <!-- Credentials Section in full width -->
                                        <h4>Credentials</h4>
                                        <a href="{{ asset('credentials/' . $professional->professionalProfile->credentials) }}" target="_blank">
                                            <img style="width: 100%; max-width: 1000px;" src="{{ asset('credentials/' . $professional->professionalProfile->credentials) }}" alt="Credentials">
                                        </a>
                                        
                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Appointment Information</h5>
                                    <hr />
                                    <!-- Tab Navigation -->
                                    <ul class="nav nav-tabs" id="appointmentTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="accepted-tab" data-bs-toggle="tab"
                                                href="#accepted" role="tab" aria-controls="accepted"
                                                aria-selected="true">
                                                Accepted Appointments
                                                <span class="badge bg-primary">{{ $acceptedBookings->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="completed-tab" data-bs-toggle="tab"
                                                href="#completed" role="tab" aria-controls="completed"
                                                aria-selected="false">
                                                Completed Appointments
                                                <span class="badge bg-success">{{ $completedBookings->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pending-tab" data-bs-toggle="tab" href="#pending"
                                                role="tab" aria-controls="pending" aria-selected="false">
                                                Pending Appointments
                                                <span class="badge bg-warning">{{ $pendingBookings->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="dispute-tab" data-bs-toggle="tab" href="#dispute"
                                                role="tab" aria-controls="dispute" aria-selected="false">
                                                Dispute Appointments
                                                <span class="badge bg-danger">{{ $disputedBookings->count() }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab Content -->
                                    <div class="tab-content" id="appointmentTabsContent">
                                        <div class="tab-pane fade show active" id="accepted" role="tabpanel"
                                            aria-labelledby="accepted-tab">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Appointment Title</th>
                                                        <th scope="col">Zoom Link</th>
                                                        <th scope="col">Customer Name</th>
                                                        <th scope="col">Date & Remaining Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($acceptedBookings as $key => $booking)
                                                        <tr>
                                                            <td width="1%">{{ $key + 1 }}</td>
                                                            <td width="40%">{{ $booking->note ?? ''  }}</td>
                                                            <td>
                                                                <!-- Making the Zoom link clickable -->
                                                                <a href="{{ $booking->zoomMeeting->join_url ?? ''  }}"
                                                                    target="_blank" style="color: aqua" class="zoom-link"
                                                                    data-booking-id="{{ $booking->id }}"> 
                                                                    Meeting Link</a>
                                                            </td>
                                                            <td>{{ $booking->user->first_name ?? ''  }}</td>
                                                            <td>
                                                                {{ \Carbon\Carbon::parse($booking->time_slot)->format('Y-m-d H:i:s') }}
                                                                <span class="countdown" id="countdown{{ $booking->id }}"
                                                                    data-time="{{ \Carbon\Carbon::parse($booking->time_slot)->format('Y-m-d H:i:s') }}"></span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Appointment Note</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($completedBookings as $key => $booking)
                                                        <tr>
                                                            <td width="1%">{{ $key + 1 }}</td>
                                                            <td width="70%">{{ $booking->note  ?? '' }}</td>
                                                            <td width="10%">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M, Y') }}</td>
                                                            <td width="19%">
                                                                @if($booking->Bookingearnings && $booking->Bookingearnings->status === 'pending')
                                                                    <form action="{{ route('admin.update.earning.status', $booking->Bookingearnings->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-info">Mark as Paid</button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-success">Paid</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="tab-pane fade" id="pending" role="tabpanel"
                                            aria-labelledby="pending-tab">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Appointment Note</th>
                                                        <th scope="col">Customer Name</th>
                                                        <th scope="col">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pendingBookings as $key => $booking)
                                                        <tr>
                                                            <td width="1%">{{ $key + 1 }}</td>
                                                            <td width="50%">{{ $booking->note ?? ''  }}</td>
                                                            <td>{{ $booking->user->first_name ?? ''  }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d M, Y') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="dispute" role="tabpanel"
                                            aria-labelledby="dispute-tab">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Dispute Reason</th>
                                                        <th scope="col">Dispute Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($disputedBookings as $key => $booking)
                                                        <tr>
                                                            <td width="1%">{{ $key + 1 }}</td>
                                                            <td width="40%">{{ $booking->reason_dispute ?? ''  }}</td>
                                                            <td>{{ $booking->dispute_detail ?? ''  }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to show remaining time (optional) -->
    <div id="countdownModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remaining Time</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalCountdown">Loading...</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function to format the countdown
        function formatTime(seconds) {
            const days = Math.floor(seconds / (3600 * 24));
            const hours = Math.floor((seconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const remainingSeconds = seconds % 60;
            return `${days} days ${hours} hours ${minutes} minutes ${remainingSeconds} seconds`;
        }

        // Loop through each countdown element and start a timer
        @foreach ($acceptedBookings as $booking)
            const countdownElement{{ $booking->id }} = document.getElementById('countdown{{ $booking->id }}');
            const endTime{{ $booking->id }} = new Date(countdownElement{{ $booking->id }}.getAttribute('data-time'))
                .getTime();

            setInterval(function() {
                const currentTime = new Date().getTime();
                const remainingTime = endTime{{ $booking->id }} - currentTime;

                if (remainingTime <= 0) {
                    countdownElement{{ $booking->id }}.textContent = "Expired";
                } else {
                    countdownElement{{ $booking->id }}.textContent = formatTime(Math.floor(remainingTime / 1000));
                }
            }, 1000);

            // Show countdown on link click
            const zoomLink{{ $booking->id }} = document.querySelector('a[data-booking-id="{{ $booking->id }}"]');
            zoomLink{{ $booking->id }}.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default link behavior
                const remainingTime = endTime{{ $booking->id }} - new Date().getTime();

                if (remainingTime <= 0) {
                    // If time is expired, redirect to Zoom link
                    window.location.href = "{{ $booking->zoomMeeting->join_url }}";
                } else {
                    // Otherwise, show the countdown in modal
                    const formattedTime = formatTime(Math.floor(remainingTime / 1000));

                    // Show countdown in modal
                    const modalCountdown = document.getElementById('modalCountdown');
                    modalCountdown.textContent = formattedTime;

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('countdownModal'));
                    modal.show();
                }
            });
        @endforeach
    </script>
@endsection
