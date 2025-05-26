@extends('admin.layouts.master')

@section('title', 'Customer Details')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Contact Details</div>
            </div>

            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Contact Information: {{ $contact->full_name }}</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Full Name Field -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $contact->full_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $contact->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Phone Field -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $contact->phone ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Message Field -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Message</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" readonly rows="4">{{ $contact->message ?? 'No message available.' }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Created At Field -->
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Created At</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $contact->created_at ? $contact->created_at->format('j M Y, g:i A') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="row mt-4">
                                        <div class="col-sm-12 text-end">
                                            <a href="{{ route('admin.Contacts') }}" class="btn btn-secondary">Back</a>
                                            {{-- <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-primary">Edit Contact</a> --}}
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
@endsection
