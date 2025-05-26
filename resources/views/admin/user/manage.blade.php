@extends('admin.layouts.master')

@section('title')
    {{ isset($user) ? 'Edit customer' : 'Create New customer' }}
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">Create Customer</h6>
                </div>
                <div class="ms-auto"><a href="{{ route('admin.customer.index') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"><i
                            class="bx bxs-plus-square"></i>Back to List</a></div>
            </div>
        </div>
        <hr />
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ isset($user) ? route('admin.customer.update', $user->id) : route('admin.customer.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($user))
                                    @method('PUT')
                                @endif
                            
                                <div class="row">
                            
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ isset($user) ? $user->first_name : old('first_name') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ isset($user) ? $user->last_name : old('last_name') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ isset($user) ? $user->email : old('email') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Password Section (Create page) -->
                                    @if (!isset($user))
                                        <div class="col-md-6">
                                            <div class="mb-3" id="password-section" style="display: block;">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" value="" required> 
                                            </div>
                                        </div>
                                    @endif
                            
                                    <!-- Password Section (Edit page) -->
                                    @if (isset($user))
                                        <div class="col-md-6">
                                            <div class="mb-3" id="password-section" style="display: none;">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" value="" >
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" style="margin-top: 27px;" id="show-password-btn" class="btn mb-1 btn-rounded btn-outline-warning">
                                                    Change Password
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                            
                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <input type="text" class="form-control" id="country" name="country" value="{{ isset($user) ? $user->country : old('country') }}">
                                        </div>
                                    </div>
                            
                                    <!-- State / City -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="state_city" class="form-label">State / City</label>
                                            <input type="text" class="form-control" id="state_city" name="state_city" value="{{ isset($user) ? $user->state_city : old('state_city') }}">
                                        </div>
                                    </div>
                            
                                    <!-- Role -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="caregiver" {{ isset($user) && $user->role == 'caregiver' ? 'selected' : '' }}>
                                                    Caregiver
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                            
                                    <!-- Age -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" name="age" value="{{ isset($user) ? $user->age : old('age') }}" required min="18">
                                        </div>
                                    </div>
                            
                                    <!-- Zip Code -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="zip" class="form-label">Zip Code</label>
                                            <input type="text" class="form-control" id="zip" name="zip" value="{{ isset($user) ? $user->zip : old('zip') }}" required>
                                        </div>
                                    </div>
                            
                                    <!-- Image Section -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select Image:</label>
                                            <div class="ml-2 col-sm-3">
                                                <img src="{{ isset($user) && $user->image ? asset('profile_image/' . $user->image) : asset('default.png') }}" id="preview" class="img-thumbnail" style="width: 260px; height: 234px;">
                                                <div id="msg"></div>
                            
                                                <input type="file" name="image" class="file" accept="image/*" style="display: none;" onchange="previewImage(event)">
                            
                                                <div class="input-group my-3 rounded-button d-flex">
                                                    <button type="button" class="btn mb-1 btn-rounded btn-outline-warning browse">Select Image</button>
                                                    <button type="button" class="btn mb-1 btn-rounded btn-outline-danger browseRemove ml-2" style="display: none;">Remove Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update Customer' : 'Save Customer' }}</button>
                                        </div>
                                    </div>
                                </div>
                            
                                <script>
                                document.querySelector('form').addEventListener('submit', function(event) {
                                    var imageInput = document.querySelector('input[name="image"]');
                                    var msg = document.getElementById('msg');
                                
                                    if (imageInput.files.length === 0) {
                                        event.preventDefault(); // Stop form submission
                                        msg.innerHTML = '<p class="text-danger">Please select an image.</p>';
                                    } else {
                                        msg.innerHTML = ''; // Clear the error message
                                    }
                                });

                                   const showPasswordBtn = document.getElementById('show-password-btn');
                                        const passwordSection = document.getElementById('password-section');

                                        // Add event listener to the button to toggle the password section visibility
                                        if (showPasswordBtn) {
                                            showPasswordBtn.addEventListener('click', function() {
                                                // Toggle the display style of the password section
                                                if (passwordSection.style.display === 'none') {
                                                    passwordSection.style.display = 'block';
                                                    showPasswordBtn.textContent = 'Hide Password'; // Optional: Change button text
                                                } else {
                                                    passwordSection.style.display = 'none';
                                                    showPasswordBtn.textContent = 'Change Password'; // Optional: Change button text
                                                }
                                            });
                                        }
                            
                                    // Image preview and remove functionality
                                    document.querySelector('.browse').addEventListener('click', function() {
                                        document.querySelector('input[name="image"]').click();
                                    });
                            
                                    function previewImage(event) {
                                        var file = event.target.files[0];
                                        var reader = new FileReader();
                            
                                        reader.onload = function(e) {
                                            var preview = document.getElementById('preview');
                                            var removeBtn = document.querySelector('.browseRemove');
                                            var msg = document.getElementById('msg');
                            
                                            preview.style.display = 'block';
                                            preview.src = e.target.result;
                                            removeBtn.style.display = 'inline-block';
                                            msg.innerHTML = '';
                            
                                            removeBtn.addEventListener('click', function() {
                                                preview.src = '{{ asset('default.png') }}';
                                                preview.style.display = 'block';
                                                removeBtn.style.display = 'none';
                                                document.querySelector('input[name="image"]').value = '';
                                            });
                                        };
                            
                                        if (file) {
                                            reader.readAsDataURL(file);
                                        } else {
                                            document.getElementById('msg').innerHTML = '<p class="text-danger">No file selected.</p>';
                                        }
                                    }
                                </script>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
