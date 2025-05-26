@extends('admin.layouts.master')

@section('title', 'Create Professional')
@section('styles')
    <style>
        .form-control[type=file]:not(:disabled):not([readonly]) {
            cursor: pointer;
            background: #000000;
            margin-top: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">Create</h6>
                </div>
                <div class="ms-auto"><a href="{{ route('admin.professionals.index') }}"
                        class="btn btn-light radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Back to List</a></div>
            </div>
        </div>
        <hr />
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('admin.professionals.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                                name="last_name" value="{{ old('last_name') }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3" id="password-section" style="display: block;">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password" value="" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <input type="text"
                                                class="form-control @error('country') is-invalid @enderror" id="country"
                                                name="country" value="{{ old('country') }}" required>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="state_city" class="form-label">State / City</label>
                                            <input type="text"
                                                class="form-control @error('state_city') is-invalid @enderror"
                                                id="state_city" name="state_city" value="{{ old('state_city') }}" required>
                                            @error('state_city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-control @error('role') is-invalid @enderror" id="role"
                                                name="role" required>
                                                <option value="professional"
                                                    {{ old('role') == 'professional' ? 'selected' : '' }}>Professional
                                                </option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control @error('age') is-invalid @enderror"
                                                id="age" name="age" value="{{ old('age') }}" min="18">
                                            @error('age')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="zip" class="form-label">Zip Code</label>
                                            <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                                id="zip" name="zip" value="{{ old('zip') }}">
                                            @error('zip')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Professional Profile Image:</label>
                                            <input type="file" name="image"
                                                class="form-control @error('image') is-invalid @enderror" required>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="professional_field" class="form-label">Professional Field</label>
                                            <input type="text"
                                                class="form-control @error('professional_field') is-invalid @enderror"
                                                id="professional_field" name="professional_field"
                                                value="{{ old('professional_field') }}" required>
                                            @error('professional_field')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="education_degrees" class="form-label">Education Degree</label>
                                            <input type="text"
                                                class="form-control @error('education_degrees') is-invalid @enderror"
                                                id="education_degrees" name="education_degrees"
                                                value="{{ old('education_degrees') }}" required>
                                            @error('education_degrees')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Professional Credentials:</label>
                                            <input type="file" name="credentials"
                                                class="form-control @error('credentials') is-invalid @enderror" required>
                                            @error('credentials')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="certifications" class="form-label">Certification</label>
                                            <input type="text"
                                                class="form-control @error('certifications') is-invalid @enderror"
                                                id="certifications" name="certifications"
                                                value="{{ old('certifications') }}" required>
                                            @error('certifications')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="skills" class="form-label">Skills</label>
                                            <input type="text"
                                                class="form-control @error('skills') is-invalid @enderror" id="skills"
                                                name="skills" value="{{ old('skills') }}" required>
                                            @error('skills')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="languages" class="form-label">Languages</label>
                                            <input type="text"
                                                class="form-control @error('languages') is-invalid @enderror"
                                                id="languages" name="languages" value="{{ old('languages') }}" required>
                                            @error('languages')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="practice" class="form-label">Practice</label>
                                            <input type="text"
                                                class="form-control @error('practice') is-invalid @enderror"
                                                id="practice" name="practice" value="{{ old('practice') }}" required>
                                            @error('practice')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hour_rate" class="form-label">Hour Rate</label>
                                            <input type="number"
                                                class="form-control @error('hour_rate') is-invalid @enderror"
                                                id="hour_rate" name="hour_rate" value="{{ old('hour_rate') }}" required>
                                            @error('hour_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="about" class="form-label">About</label>
                                            <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="3">{{ old('about') }}</textarea>
                                            @error('about')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text"
                                                class="form-control @error('website') is-invalid @enderror"
                                                id="phone" name="phone" value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="website" class="form-label">Website URL</label>
                                            <input type="text"
                                                class="form-control @error('website') is-invalid @enderror"
                                                id="website" name="website" value="{{ old('website') }}">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <!-- Work Experience Section -->
                                <div class="modal-body">
                                    <h6>Work Experience</h6>
                                    <table class="table table-bordered" id="experienceTable">
                                        <thead>
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Company Name</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="experienceSection">
                                            <tr class="experience-row">
                                                <td><input type="text" name="work_experience[0][job_title]"
                                                        class="form-control" required></td>
                                                <td><input type="text" name="work_experience[0][company_name]"
                                                        class="form-control" required></td>
                                                <td><input type="date" name="work_experience[0][from]"
                                                        class="form-control" required></td>
                                                <td><input type="date" name="work_experience[0][to]"
                                                        class="form-control" required></td>
                                                <td><button type="button"
                                                        class="btn btn-danger"onclick="removeExperienceRow(this)"><i
                                                            class='bx bxs-trash'></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" onclick="addExperienceRow()"><i
                                            class="bx bxs-plus-square"></i></button>
                                </div>

                                <!-- Licenses Section -->
                                <div class="modal-body">
                                    <h6>Licenses</h6>
                                    <table class="table table-bordered" id="licenseTable">
                                        <thead>
                                            <tr>
                                                <th>License Name</th>
                                                <th>License ID</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="licenseSection">
                                            <tr class="license-row">
                                                <td><input type="text" name="licenses[0][license_name]"
                                                        class="form-control" required></td>
                                                <td><input type="text" name="licenses[0][license_id]"
                                                        class="form-control" required></td>
                                                <td><input type="date" name="licenses[0][from]" class="form-control"
                                                        required></td>
                                                <td><input type="date" name="licenses[0][to]" class="form-control"
                                                        required></td>
                                                <td><button type="button" class="btn btn-danger"
                                                        onclick="removeLicenseRow(this)"><i
                                                            class='bx bxs-trash'></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" onclick="addLicenseRow()"><i
                                            class="bx bxs-plus-square"></i></button>

                                    <br><br>
                                    <!-- Submit Button -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success">Save Professional</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Add and Remove Experience Rows
        let experienceRowCount = 1; // Track the number of experience rows

        function addExperienceRow() {
            // Clone the first experience row
            let newRow = document.querySelector('#experienceSection .experience-row').cloneNode(true);

            // Clear the input values
            let inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });

            // Update the input names with the new row index
            newRow.querySelectorAll('input').forEach(input => {
                let name = input.name;
                input.name = name.replace(/\[\d+\]/, `[${experienceRowCount}]`);
            });

            // Append the new row
            document.getElementById('experienceSection').appendChild(newRow);
            experienceRowCount++; // Increment row count for the next row
        }

        function removeExperienceRow(button) {
            let rows = document.querySelectorAll('#experienceSection .experience-row');
            if (rows.length > 1) {
                let row = button.closest('.experience-row');
                row.remove();
            } else {
                alert("At least one experience row must remain.");
            }
        }

        // Add and Remove License Rows
        let licenseRowCount = 1; // Track the number of license rows

        function addLicenseRow() {
            // Clone the first license row
            let newRow = document.querySelector('#licenseSection .license-row').cloneNode(true);
 
            let inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });

            // Update the input names with the new row index
            newRow.querySelectorAll('input').forEach(input => {
                let name = input.name;
                input.name = name.replace(/\[\d+\]/, `[${licenseRowCount}]`);
            });

            // Append the new row
            document.getElementById('licenseSection').appendChild(newRow);
            licenseRowCount++; // Increment row count for the next row
        }

        function removeLicenseRow(button) {
            let rows = document.querySelectorAll('#licenseSection .license-row');
            if (rows.length > 1) {
                let row = button.closest('.license-row');
                row.remove();
            } else {
                alert("At least one license row must remain.");
            }
        }
    </script>


@endsection
