@extends('admin.layouts.master')

@section('title', 'Update Professional')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">Edit {{ $professional->first_name ?? '' }}</h6>
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
                            <form action="{{ route('admin.professionals.update', $professional->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                value="{{ $professional->first_name ?? old('first_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                value="{{ $professional->last_name ?? old('last_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $professional->email ?? old('email') }}" readonly>
                                        </div>
                                    </div>
                                    @if (!isset($professional))
                                        <div class="col-md-4">
                                            <div class="mb-3" id="password-section" style="display: block;">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    value="" required>
                                            </div>
                                        </div>
                                    @endif

                                    @if (isset($professional))
                                        <div class="col-md-4">
                                            <div class="mb-3" id="password-section" style="display: none;">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    value="">
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" style="margin-top: 27px;" id="show-password-btn"
                                                    class="btn mb-1 btn-rounded btn-outline-warning">
                                                    Change Password
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                value="{{ $professional->country ?? old('country') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="state_city" class="form-label">State / City</label>
                                            <input type="text" class="form-control" id="state_city" name="state_city"
                                                value="{{ $professional->state_city ?? old('state_city') }}" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="caregiver"
                                                    {{ isset($professional) && $professional->role == 'caregiver' ? 'selected' : '' }}>
                                                    Caregiver
                                                </option>
                                                <option value="professional"
                                                    {{ isset($professional) && $professional->role == 'professional' ? 'selected' : '' }}>
                                                    Professional
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" name="age"
                                                value="{{ $professional->age ?? old('age') }}" required min="18">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="zip" class="form-label">Zip Code</label>
                                            <input type="text" class="form-control" id="zip" name="zip"
                                                value="{{ $professional->zip ?? old('zip') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Professional Profile Image:</label>
                                            <input type="file" name="image" class="form-control" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="professional_field" class="form-label">Professional Field</label>
                                            <input type="text" class="form-control" id="professional_field"
                                                name="professional_field"
                                                value="{{ $professional->professionalProfile->professional_field ?? old('professional_field') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="education_degrees" class="form-label">Education Degree</label>
                                            <input type="text" class="form-control" id="education_degrees"
                                                name="education_degrees"
                                                value="{{ $professional->professionalProfile->education_degrees ?? old('education_degrees') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Professional Credentials:</label>
                                            <input type="file" name="credentials" class="form-control"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="certifications" class="form-label">Certification</label>
                                            <input type="text" class="form-control" id="certifications"
                                                name="certifications"
                                                value="{{ $professional->professionalProfile->certifications ?? old('certifications') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="skills" class="form-label">Skills</label>
                                            <input type="text" class="form-control" id="skills" name="skills"
                                                value="{{ implode(', ', json_decode($professional->professionalProfile->skills ?? '[]')) ?? old('skills') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="languages" class="form-label">Languages</label>
                                            <input type="text" class="form-control" id="languages" name="languages"
                                                value="{{ implode(', ', json_decode($professional->professionalProfile->languages ?? '[]')) ?? old('languages') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="practice" class="form-label">Practice</label>
                                            <input type="text" class="form-control" id="practice" name="practice"
                                                value="{{ implode(', ', json_decode($professional->professionalProfile->practice ?? '[]')) ?? old('practice') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hour_rate" class="form-label">Hour Rate</label>
                                            <input type="text" class="form-control" id="hour_rate" name="hour_rate"
                                                value="{{ $professional->professionalProfile->hour_rate ?? old('hour_rate') }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="zip" class="form-label">About</label>
                                            <textarea name="about" class="form-control" id="" cols="" rows="3">{{ $professional->professionalProfile->about ?? old('about') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text"
                                                class="form-control @error('website') is-invalid @enderror" id="phone"
                                                name="phone" value="{{ $professional->phone ?? old('phone') }}"
                                                required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="website" class="form-label">Website URL</label>
                                            <input type="text" class="form-control" id="website" name="website"
                                                value="{{ $professional->professionalProfile->website ?? old('website') }}"
                                                required>
                                        </div>
                                    </div>

                                </div>




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
                                            @forelse ($professional?->experiences ?? [] as $index => $experience)
                                                <tr class="experience-row">
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="work_experience[{{ $index }}][job_title]"
                                                            value="{{ $experience->job_title }}"
                                                            placeholder="Job Title" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="work_experience[{{ $index }}][company_name]"
                                                            value="{{ $experience->company_name }}"
                                                            placeholder="Company Name" />
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control"
                                                            name="work_experience[{{ $index }}][from]"
                                                            value="{{ $experience->from }}" placeholder="From" />
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control"
                                                            name="work_experience[{{ $index }}][to]"
                                                            value="{{ $experience->to }}" placeholder="To" />
                                                    </td>
                                                    <td>
                                                        {{-- <input type="hidden"
                                                            name="work_experience[{{ $index }}][deleted]"
                                                            class="deleted_experience" value="false" /> --}}
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="removeExperienceRow(this)">
                                                            <i class='bx bxs-trash'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No experiences available.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" onclick="addExperienceRow()"><i
                                            class="bx bxs-plus-square"></i></button>
                                </div>

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
                                            @foreach ($professional?->licenses ?? [] as $index => $license)
                                                <tr class="license-row">
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="licenses[{{ $index }}][license_name]"
                                                            value="{{ $license->license_name }}"
                                                            placeholder="License Name" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="licenses[{{ $index }}][license_id]"
                                                            value="{{ $license->license_id }}"
                                                            placeholder="License ID" />
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control"
                                                            name="licenses[{{ $index }}][from]"
                                                            value="{{ $license->from }}" placeholder="From" />
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control"
                                                            name="licenses[{{ $index }}][to]"
                                                            value="{{ $license->to }}" placeholder="To" />
                                                    </td>
                                                    <td>
                                                        <input type="hidden"
                                                            name="licenses[{{ $index }}][deleted]"
                                                            class="deleted_license" value="false" />
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="removeLicenseRow(this)">
                                                            <i class='bx bxs-trash'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" onclick="addLicenseRow()"><i
                                            class="bx bxs-plus-square"></i></button>
                                </div>



                                <div class="col-md-6" style="margin-left:15px">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success"> Update Professional </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control[type=file]:not(:disabled):not([readonly]) {
            cursor: pointer;
            background: #000000;
            margin-top: 8px
        }
    </style>


@endsection

@section('scripts')
    <script>
        // Initialize row counts if not already done (ensure these variables are defined)
        let experienceRowCount = document.querySelectorAll('#experienceTable .experience-row').length;
        let licenseRowCount = document.querySelectorAll('#licenseTable .license-row').length;

        function addExperienceRow() {
            let templateRow = document.querySelector('#experienceTable .experience-row');
            if (templateRow) {
                let newRow = templateRow.cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                    let name = input.name;
                    input.name = name.replace(/\[\d+\]/, `[${experienceRowCount}]`);
                });

                document.getElementById('experienceSection').appendChild(newRow);
                experienceRowCount++;
            }
        }



        function reIndexTable() {
            var j = 0
            $('#experienceTable tbody tr').each(function() {
                $(this).attr('id', j)
                $(this).find('[name*=job_title]').attr('name', "work_experience[" + j + "][job_title]")
                $(this).find('[name*=company_name]').attr('name', "work_experience[" + j + "][company_name]")
                $(this).find('[name*=from]').attr('name', "work_experience[" + j + "][from]")
                $(this).find('[name*=to]').attr('name', "work_experience[" + j + "][to]")
                j++;
            });
        }

        function reIndexTableLicense() {
            var j = 0
            $('#licenseTable tbody tr').each(function() {
                $(this).attr('id', j)
                $(this).find('[name*=license_name]').attr('name', "licenses[" + j + "][license_name]")
                $(this).find('[name*=license_id]').attr('name', "licenses[" + j + "][license_id]")
                $(this).find('[name*=from]').attr('name', "licenses[" + j + "][from]")
                $(this).find('[name*=to]').attr('name', "licenses[" + j + "][to]")
                j++;
            });
        }



        function removeExperienceRow(button) {
            let row = button.closest('.experience-row');
            // let deletedInput = row.querySelector('.deleted_experience');
            // deletedInput.value = 'true';  
            // row.classList.add('deleted');  

            let rows = document.querySelectorAll('#experienceTable .experience-row');
            if (rows.length > 1) {
                row.remove();
                reIndexTable();
                experienceRowCount--;
            } else {
                alert("At least one experience row must remain.");
            }
        }

        function removeLicenseRow(button) {
            let row = button.closest('.license-row');
            // let deletedInput = row.querySelector('.deleted_license');
            // deletedInput.value = 'true'; // Mark it as deleted
            // row.classList.add('deleted'); // Add a class for styling (optional)

            let rows = document.querySelectorAll('#licenseTable .license-row');
            if (rows.length > 1) { // Ensure at least one row remains
                row.remove(); // Remove the row
                reIndexTableLicense(); //
                licenseRowCount--; // Decrease row count
            } else {
                alert("At least one license row must remain.");
            }
        }




        function addLicenseRow() {
            let templateRow = document.querySelector('#licenseTable .license-row');
            if (templateRow) {
                let newRow = templateRow.cloneNode(true);

                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                    let name = input.name;
                    input.name = name.replace(/\[\d+\]/, `[${licenseRowCount}]`);
                });

                document.getElementById('licenseSection').appendChild(newRow);
                licenseRowCount++;
            }
        }

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
    </script>
@endsection
