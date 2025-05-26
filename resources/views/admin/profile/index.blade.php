@extends('admin.layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Profile : {{ Auth::user()->first_name }}</div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <label for="image" class="image-label position-relative">
                                    <img id="adminImage"
                                        src="{{ auth()->user()->image ? asset('profile_image/' . auth()->user()->image) : 'https://via.placeholder.com/150' }}"
                                        alt="Admin Image" style="width: 300px; height: 416px; object-fit: contain;">
                                    <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center"
                                        style="background-color: rgba(0, 0, 0, 0.5); display: none; color: white;">
                                        <span>Click to change</span>
                                    </div>
                                </label>
                                <input type="file" name="image" id="image" class="d-none"
                                    onchange="previewImage(event)">
                            </div>

                            <!-- Input Fields (Right) -->
                            <div class="col-md-8">
                                <!-- First Name -->
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">First Name</span>
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                        value="{{ auth()->user()->first_name }}" required>
                                </div>
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">Last Name</span>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        value="{{ auth()->user()->last_name }}" required>
                                </div>

                                <!-- Email -->
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">Email</span>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ auth()->user()->email }}" required>
                                </div>


                                
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">Password</span>
                                    <input type="text" name="password" class="form-control" placeholder="password"
                                        value="">
                                </div>

                                <!-- Phone -->
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">Phone</span>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone"
                                        value="{{ auth()->user()->phone }}" required>
                                </div>

                                <!-- Country -->
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">Country</span>
                                    <input type="text" name="country" class="form-control" placeholder="Country"
                                        value="{{ auth()->user()->country }}" required>
                                </div>

                                <!-- State/City -->
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">State/City</span>
                                    <input type="text" name="state_city" class="form-control" placeholder="State/City"
                                        value="{{ auth()->user()->state_city }}" required>
                                </div>

                                <!-- Zip -->
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text">Zip</span>
                                    <input type="text" name="zip" class="form-control" placeholder="Zip"
                                        value="{{ auth()->user()->zip }}" required>
                                </div>



                                <button type="submit" class="btn btn-info px-5">Update Profile</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        // Function to preview image before upload
                        function previewImage(event) {
                            var output = document.getElementById('adminImage');
                            output.src = URL.createObjectURL(event.target.files[0]);
                        }

                        // Show overlay on image hover
                        document.querySelector('.image-label').addEventListener('mouseover', function() {
                            document.querySelector('.image-overlay').style.display = 'flex';
                        });

                        document.querySelector('.image-label').addEventListener('mouseout', function() {
                            document.querySelector('.image-overlay').style.display = 'none';
                        });
                    </script>




                </div>
            </div>
        </div>
    </div>
@endsection
