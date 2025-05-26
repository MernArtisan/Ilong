@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
          
            <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-4">
                <div class="col">
                    <a href="{{ route('admin.customer.index') }}">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0">Total Customers</p>
                                        <h4 class="my-1">{{ $totalUsers }}</h4>
                                        <p class="mb-0 font-13"><i class='bx bxs-up-arrow align-middle'></i>14% Since last week</p>
                                    </div>
                                    <div class="widgets-icons ms-auto"><i class='bx bx-user'></i></div>
                                </div>
                                <div class="progress my-3" style="height:3px;">
                                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 ms-auto">{{ $totalUsers }}<span><i class='bx bx-user'></i></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('admin.professionals.index') }}">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0">Total Professionals</p>
                                        <h4 class="my-1">{{ $totalProfessionals }}</h4>
                                        <p class="mb-0 font-13"><i class='bx bxs-up-arrow align-middle'></i>14% Since last week</p>
                                    </div>
                                    <div class="widgets-icons ms-auto"><i class='bx bx-briefcase'></i></div>
                                </div>
                                <div class="progress my-3" style="height:3px;">
                                    <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 ms-auto">{{ $totalProfessionals }}<span><i class='bx bx-briefcase'></i></span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Successful Appointments</p>
                                    <h4 class="my-1">{{ $totalBookings }}</h4>
                                    <p class="mb-0 font-13"><i class='bx bxs-up-arrow align-middle'></i>10% Since last week</p>
                                </div>
                                <div class="widgets-icons ms-auto"><i class='bx bx-check-circle'></i></div>
                            </div>
                            <div class="progress my-3" style="height:3px;">
                                <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 ms-auto">{{ $totalBookings }}<span><i class='bx bx-check-circle'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Pending Appointments</p>
                                    <h4 class="my-1">{{ $totalPendingOrOther }}</h4>
                                    <p class="mb-0 font-13"><i class='bx bxs-up-arrow align-middle'></i>5% Since last week</p>
                                </div>
                                <div class="widgets-icons ms-auto"><i class='bx bx-time'></i></div>
                            </div>
                            <div class="progress my-3" style="height:3px;">
                                <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 ms-auto">{{ $totalPendingOrOther }}<span><i class='bx bx-time'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card radius-10 overflow-hidden w-100" style="height: 550px;">
                        <div class="card-body">
                            <!-- Calendar for date range selection -->
                            <div class="mb-4">
                                <input type="text" id="calendar" class="form-control form-control-lg" placeholder="Select date range"
                                    value="{{ $selectedDate }}">
                            </div>
                
                            <div class="mb-4">
                                <p class="">Total Earnings (Selected Range)</p>
                                <h4 class="mb-2 font-weight-bold" id="currentMonthEarnings">{{ number_format($currentMonthEarnings, 2) }}</h4>
                                <small id="percentageChange" class="d-flex align-items-center">
                                    <span>{{ number_format($percentageChangeCurrentVsLastMonth, 2) }}%</span>
                                    <i class="zmdi ml-2 {{ $percentageChangeCurrentVsLastMonth > 0 ? 'zmdi-long-arrow-up text-success' : 'zmdi-long-arrow-down text-danger' }}"></i>
                                </small>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="mb-4">
                                <p class="">Admin's Share (9%)</p>
                                <h4 class="mb-2 font-weight-bold" id="adminEarningsCurrentMonth">{{ number_format($adminEarningsCurrentMonth, 2) }}</h4>
                            </div>
                
                            <div>
                                <p class="">Professional's Share (91%)</p>
                                <h4 class="mb-0 font-weight-bold" id="professionalEarningsCurrentMonth">{{ number_format($professionalEarningsCurrentMonth, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-lg-6 col-xl-8 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header border-bottom">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Customer Dispute Appointments</h6>
                                </div>
                                <div class="font-22 ms-auto text-white"><i class="bx bx-dots-horizontal-rounded"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example8" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Professional Name</th>
                                        <th>Reason of Dispute</th>
                                        <th>Dispute Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($totalDispute as $totalDisputeItem)
                                        <tr>
                                            <td>
                                                {{ $totalDisputeItem->user->first_name }}
                                                {{ $totalDisputeItem->user->last_name }}
                                                <br>
                                                {{ $totalDisputeItem->created_at->diffForHumans() }}
                                            </td>
                                            <td>{{ $totalDisputeItem->professional->first_name ?? 'N/A' }}
                                                {{ $totalDisputeItem->professional->last_name ?? 'N/A' }}</td>
                                            <td>{{ $totalDisputeItem->reason_dispute }}</td>
                                            <td>{{ $totalDisputeItem->dispute_detail }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 


            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Appointments Summary</h5>
                        </div>
                        <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i></div>
                    </div>
                    <hr>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills" id="appointmentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="request-tab" data-bs-toggle="pill" href="#request"
                                role="tab" aria-controls="request" aria-selected="false">Request Appointments
                                <span
                                    style="background: rgb(241, 241, 131); font-size: 15px; color: black; padding: 5px 5px; border: 2px solid #fff; border-radius: 12px;">
                                    {{ $totalAppointmentRequest->count() }}
                                </span>
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="accepted-tab" data-bs-toggle="pill" href="#accepted" role="tab"
                                aria-controls="accepted" aria-selected="true">Accepted Appointments
                                <span
                                    style="background: rgb(90, 255, 255); font-size: 15px; color: black; padding: 5px 5px; border: 2px solid #fff; border-radius: 12px;">
                                    {{ $totalAppointmentAccepted->count() }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="completed-tab" data-bs-toggle="pill" href="#completed"
                                role="tab" aria-controls="completed" aria-selected="false">Completed Appointments
                                <span
                                    style="background: rgb(59, 226, 109); font-size: 15px; color: black; padding: 5px 5px; border: 2px solid #fff; border-radius: 12px;">
                                    {{ $totalAppointmentCompleted->count() }}
                                </span>
                            </a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link" id="dispute-tab" data-bs-toggle="pill" href="#dispute" role="tab" aria-controls="dispute" aria-selected="false">Dispute Appointments</a>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="cancelled-tab" data-bs-toggle="pill" href="#cancelled"
                                role="tab" aria-controls="cancelled" aria-selected="false">Cancelled Appointments
                                <span
                                    style="background: rgb(255, 61, 61); font-size: 15px; color: black; padding: 5px 5px; border: 2px solid #fff; border-radius: 12px;">
                                    {{ $totalAppointmentCancelled->count() }}
                                </span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content mt-3" id="appointmentTabsContent">

                        <!-- Request Appointments Tab -->
                        <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="request-tab">
                            <div class="table-responsive">
                                <table id="example4" class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Professional</th>
                                            <th>Date</th>
                                            <th>Appointment Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($totalAppointmentRequest as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($item->user) && $item->user->image)
                                                                <img src="{{ asset('profile_image/' . $item->user->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $item->user->first_name ?? 'N/A' }} {{ $item->user->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                        
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($item->professional) && $item->professional->image)
                                                                <img src="{{ asset('profile_image/' . $item->professional->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $item->professional->first_name ?? 'N/A' }} {{ $item->professional->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item->created_at->format('j M Y') ?? 'N/A' }}</td>
                                                <td>{{ $item->note ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Accepted Appointments Tab -->
                        <div class="tab-pane fade show" id="accepted" role="tabpanel" aria-labelledby="accepted-tab">
                            <div class="table-responsive">
                                <table id="example3" class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Professional</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Note Appointment</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($totalAppointmentAccepted as $key => $itemAccepted)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($itemAccepted->user) && $itemAccepted->user->image)
                                                                <img src="{{ asset('profile_image/' . $itemAccepted->user->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $itemAccepted->user->first_name ?? 'N/A' }} {{ $itemAccepted->user->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                        
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($itemAccepted->professional) && $itemAccepted->professional->image)
                                                                <img src="{{ asset('profile_image/' . $itemAccepted->professional->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $itemAccepted->professional->first_name ?? 'N/A' }} {{ $itemAccepted->professional->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $itemAccepted->created_at->format('j M Y') ?? 'N/A' }}</td>
                                                <td>${{ $itemAccepted->professional->professionalProfile->hour_rate ?? 'N/A' }}</td>
                                                <td>{{ $itemAccepted->note ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="btn btn-info btn-sm">{{ $itemAccepted->status ?? 'N/A' }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Completed Appointments Tab -->
                        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                            <div class="table-responsive">
                                <table id="example5" class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Professional</th>
                                            <th>Date</th>
                                            <th>Appointment Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($totalAppointmentCompleted as $key => $itemCompleted)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($itemCompleted->user) && $itemCompleted->user->image)
                                                                <img src="{{ asset('profile_image/' . $itemCompleted->user->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $itemCompleted->user->first_name ?? 'N/A' }} {{ $itemCompleted->user->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                        
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($itemCompleted->professional) && $itemCompleted->professional->image)
                                                                <img src="{{ asset('profile_image/' . $itemCompleted->professional->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $itemCompleted->professional->first_name ?? 'N/A' }} {{ $itemCompleted->professional->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $itemCompleted->created_at->format('j M Y') ?? 'N/A' }}</td>
                                                <td>{{ $itemCompleted->note ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Cancelled Appointments Tab -->
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                            <div class="table-responsive">
                                <table id="example7" class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Professional</th>
                                            <th>Date</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($totalAppointmentCancelled as $key => $itemCancelled)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($itemCancelled->user) && $itemCancelled->user->image)
                                                                <img src="{{ asset('profile_image/' . $itemCancelled->user->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $itemCancelled->user->first_name ?? 'N/A' }} {{ $itemCancelled->user->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                        
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            @if (isset($itemCancelled->professional) && $itemCancelled->professional->image)
                                                                <img src="{{ asset('profile_image/' . $itemCancelled->professional->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('default.png') }}" alt="Default Image">
                                                            @endif
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">
                                                                {{ $itemCancelled->professional->first_name ?? 'N/A' }} {{ $itemCancelled->professional->last_name ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $itemCancelled->created_at->format('j M Y') ?? 'N/A' }}</td>
                                                <td>{{ $itemCancelled->reason ?? 'N/A' }}</td>
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
@endsection
