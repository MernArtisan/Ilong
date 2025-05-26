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
         {{-- 
         <div class="ms-auto">
            <div class="btn-group">
               <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
               {{ ucfirst($professional->login_status) }}
               </button>
               <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                  <!-- Approve Option -->
                  <a class="dropdown-item {{ $professional->login_status == 'approve' ? 'active' : '' }}"
                     href="javascript:void(0);" onclick="changeStatus('approve', {{ $professional->id }})">
                  Approve
                  </a>
                  <!-- Reject Option -->
                  <a class="dropdown-item {{ $professional->login_status == 'reject' ? 'active' : '' }}"
                     href="javascript:void(0);" onclick="changeStatus('reject', {{ $professional->id }})">
                  Reject
                  </a>
               </div>
            </div>
         </div>
         --}}
      </div>
      <div class="container">
         <div class="main-body">
            <div class="row">
               <div class="col-lg-4">
                  <div class="card">
                     <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                           <img src="{{ asset('profile_image/' . $professional->image) }}" alt="Admin"
                              style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border: 4px solid #ccc;"
                              width="225">
                           <div class="mt-3">
                              <h4>{{ $professional->first_name ?? '' }} {{ $professional->last_name ?? '' }}
                              </h4>
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
                              <span class="text-white">{{ $professional->country ?? '' }}</span>
                           </li>
                           <li
                              class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                              <h6 class="mb-0">State/City</h6>
                              <span class="text-white">{{ $professional->state_city ?? '' }}</span>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-lg-8">
                  <div class="card">
                     <div class="card-body">
                        <!-- Edit Button at the Top -->
                        <div class="d-flex justify-content-between mb-4">
                           <h5 class="card-title">Professional Details</h5>
                           <a href="{{ route('admin.professionals.edit', $professional->id) }}"
                              class="btn btn-primary btn-sm">Edit</a>
                        </div>
                        <!-- Fields -->
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Full Name</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="{{ $professional->first_name ?? '' }} {{ $professional->last_name ?? '' }}"
                                 readonly />
                           </div>
                        </div>
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Email</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="{{ $professional->email ?? '' }}" readonly />
                           </div>
                        </div>
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Phone</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="{{ $professional->phone ?? '' }}" readonly />
                           </div>
                        </div>
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Created At</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="{{ $professional->created_at->format('j M Y') }}" readonly />
                           </div>
                        </div>
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Role</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="{{ $professional->role ?? '' }}" readonly />
                           </div>
                        </div>
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Zip Code</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="{{ $professional->zip ?? '' }}" readonly />
                           </div>
                        </div>
                        <div class="row mb-3">
                           <div class="col-sm-3">
                              <h6 class="mb-0
                                 ">Hour Rate</h6>
                           </div>
                           <div class="col-sm-9">
                              <input type="text" class="form-control"
                                 value="${{ $professional->professionalProfile->hour_rate ?? '' }}"
                                 readonly />
                           </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                           <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                              data-bs-target="#viewOtherDetailsModal">View Details</button>
                           <div class="btn-group">
                              <button type="button" class="btn btn-danger btn-sm"
                                 onclick="changeStatus('reject', {{ $professional->id }})">
                              Reject
                              </button>
                              <button type="button" class="btn btn-success btn-sm"
                                 onclick="changeStatus('approve', {{ $professional->id }})">
                              Approve
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="viewOtherDetailsModal" tabindex="-1"
                  aria-labelledby="viewOtherDetailsModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="viewOtherDetailsModalLabel">Other Details</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal"
                              aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <!-- Additional Details Content -->
                           <p>Here are additional details about the professional:</p>
                           <!-- Work Experience and Licenses in two columns -->
                           <div class="row">
                              <!-- Left column for Work Experience -->
                              <div class="col-md-6">
                                 <h6>Work Experience</h6>
                                 @if ($professional->experiences->isNotEmpty())
                                 <ul>
                                    @foreach ($professional->experiences as $experience)
                                    <li>
                                       <strong>{{ $experience->job_title }}</strong> at
                                       <em>{{ $experience->company_name }}</em><br>
                                       From: {{ $experience->from }} To:
                                       {{ $experience->to }}<br>
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
                                 @if ($professional->licenses->isNotEmpty())
                                 <ul>
                                    @foreach ($professional->licenses as $license)
                                    <li>
                                       <strong>{{ $license->license_name }}</strong> (License ID:
                                       {{ $license->license_id }})<br>
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
                           <a href="{{ asset('credentials/' . $professional->professionalProfile->credentials) }}"
                              target="_blank">
                           <img style="width: 100%; max-width: 1000px;"
                              src="{{ asset('credentials/' . $professional->professionalProfile->credentials) }}"
                              alt="Credentials">
                           </a>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary"
                              data-bs-dismiss="modal">Close</button>
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
</script>
@endsection