<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />

    <link href="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css?=ww') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>

    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/app.css?=er') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @yield('styles')
</head>

<body class="bg-theme bg-theme7">
    <style>
        .note-editor {
            background-color: white !important;
            color: black;
        }

        .note-toolbar {
            background-color: white !important;
            border-bottom: 1px solid #ddd;
        }

        .note-toolbar .note-btn {
            color: black !important;
        }

        .toast-success {
            background-color: #aeff9e !important;
            color: #000000 !important;
        }

        .toast-success .toast-message {
            font-size: 14px;
        }
    </style>
    <div class="wrapper">
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <input type="text" class="form-control search-control" id="search-input"
                                placeholder="Type to search...">
                            <span class="position-absolute top-50 search-show translate-middle-y"><i
                                    class='bx bx-search'></i></span>
                            <span class="position-absolute top-50 search-close translate-middle-y"><i
                                    class='bx bx-x'></i></span>

                            <!-- Search results dropdown -->
                            <div id="search-results" class="search-results-box"
                                style="display: none; position: absolute; width: 100%; background: rgb(43, 190, 146); border: 1px solid #ccc; z-index: 1000;">
                            </div>
                        </div>
                    </div>

                    <script> 
                        document.getElementById('search-input').addEventListener('input', function() {
                            let query = this.value;

                            if (query.length > 2) { // Start searching after typing 2 characters
                                fetch(`/super-search?query=${query}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        let resultsDiv = document.getElementById('search-results');
                                        resultsDiv.innerHTML = '';

                                        if (data.users.length > 0) {
                                            resultsDiv.style.display = 'block'; // Show results dropdown

                                            data.users.forEach(user => {
                                                // Create a clickable result item
                                                let resultItem = document.createElement('div');
                                                resultItem.classList.add('search-result-item');
                                                resultItem.style.padding = '10px';
                                                resultItem.style.cursor = 'pointer';
                                                resultItem.style.color = 'white';
                                                resultItem.style.background = 'rgb(9 130 119)';
                                                // Add profile image and name
                                                let image =
                                                    `<img src="${user.profile_image_url}" alt="${user.first_name}" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">`;

                                                resultItem.innerHTML =
                                                    `${image} ${user.first_name} ${user.last_name} (${user.role})`;
                                                resultItem.addEventListener('click', function() {
                                                    if (user.role === 'caregiver') {
                                                        window.location.href =
                                                            `/user/${user.id}`; // Redirect for caregiver
                                                    } else if (user.role === 'professional') {
                                                        window.location.href =
                                                            `/professionals/${user.id}`; // Redirect for professional
                                                    }
                                                });

                                                resultsDiv.appendChild(resultItem);
                                            });
                                        } else {
                                            resultsDiv.style.display = 'none'; // Hide if no results
                                        }
                                    });
                            } else {
                                document.getElementById('search-results').style.display = 'none'; // Hide if query is too short
                            }
                        });
                    </script>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            {{-- <li class="nav-item mobile-search-icon">
                                <a class="nav-link" href="#">
                                    <i class='bx bx-search'></i>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">
                                        {{  $pendingCount }} <!-- Combined Count for both -->
                                    </span>
                                    <i class='bx bx-user'></i>
                                </a>
                            
                                <!-- Dropdown Menu for Pending Users and Notifications -->
                                <ul class="dropdown-menu dropdown-menu-end p-2" style="margin-right: 1px">
                            
                                    <!-- Pending Professionals Section -->
                                    @if ($pendingCount > 0)
                                        <li class="dropdown-item">
                                            <strong>{{ $pendingCount }} New Register Professionals</strong>
                                        </li>
                                        @foreach ($pendingUsers as $user)
                                            <a href="{{ route('admin.requestShow', $user->id) }}">
                                                <li class="d-flex align-items-center py-2">
                                                    <img src="{{ asset('profile_image/' . $user->image) }}"
                                                        alt="User Image" width="30" height="30" class="rounded-circle">
                                                    <span class="ms-2">{{ $user->first_name }} {{ $user->last_name }}</span>
                                                </li>
                                            </a>
                                        @endforeach
                                    @else
                                        <li class="dropdown-item">
                                            No Register Professionals.
                                        </li>
                                    @endif
                                    <li class="dropdown-item-divider"></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                    <style>
                        /* Align dropdown menu to the right of the bell icon */
                        .dropdown-menu-end {
                            right: 0;
                        }

                        /* Add padding to the user details in the dropdown */
                        .dropdown-item {
                            padding-left: 10px;
                            padding-right: 10px;
                        }

                        /* Space between the image and text */
                        .dropdown-item img {
                            margin-right: 10px;
                        }
                    </style>

                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('profile_image/' . Auth::user()->image) }}" class="user-img"
                                alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</p>
                                <p class="designattion mb-0">{{ Auth::user()->role }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i
                                        class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                        class='bx bx-home-circle'></i><span>Dashboard</span></a></li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i
                                            class="bx bx-log-out"></i><span>Logout</span></button>
                                </form>
                            </li>


                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        @include('admin.layouts.sidebar')
        @yield('content')
    </div>

    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/jquery-knob/excanvas.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
    <script src="{{ asset('admin/assets/js/index.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            // Flatpickr ko range select ke liye initialize kar rahein hain
            flatpickr("#calendar", {
                mode: "range", // Yeh option date range ke liye hai
                dateFormat: "Y-m-d", // Format year-month-day
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        // Dono dates select hone ke baad hi request bhejein
                        getEarningsForSelectedDate(selectedDates[0], selectedDates[1]);
                    }
                }
            });
        });

        function getEarningsForSelectedDate(startDate, endDate) {
            $.ajax({
                url: '/get-earnings', // Adjust to your route for earnings
                method: 'GET',
                data: {
                    startDate: startDate.toISOString().slice(0, 10), // Format date as YYYY-MM-DD
                    endDate: endDate.toISOString().slice(0, 10)
                },
                success: function(response) {
                    // Page ko new earnings data ke saath update karain
                    $('#currentMonthEarnings').text(response.currentMonthEarnings);
                    $('#adminEarningsCurrentMonth').text(response.adminEarningsCurrentMonth);
                    $('#professionalEarningsCurrentMonth').text(response.professionalEarningsCurrentMonth);
                    $('#lastMonthEarnings').text(response.lastMonthEarnings);
                    $('#adminEarningsLastMonth').text(response.adminEarningsLastMonth);
                    $('#professionalEarningsLastMonth').text(response.professionalEarningsLastMonth);
                    $('#percentageChange').text(response.percentageChangeCurrentVsLastMonth + "%");

                    // Percentage change ke liye arrow icon update karein
                    $('#percentageChange i').attr('class', 'zmdi ' + (response
                        .percentageChangeCurrentVsLastMonth > 0 ? 'zmdi-long-arrow-up' :
                        'zmdi-long-arrow-down'));
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });


        $(document).ready(function() {
            var table = $('#example3').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });

        $(document).ready(function() {
            var table = $('#example4').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });

        $(document).ready(function() {
            var table = $('#example5').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });

        $(document).ready(function() {
            var table = $('#example6').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });

        $(document).ready(function() {
            var table = $('#example7').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });

        $(document).ready(function() {
            var table = $('#example8').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
    <script>
        @if (session('success'))
            var successSound = new Audio('{{ asset('admin/assets/sounds/success.mp3') }}'); // success sound
            successSound.play();
            toastr.success('{{ session('success') }}', 'Success');
        @endif

        @if (session('error'))
            var errorSound = new Audio('{{ asset('admin/assets/sounds/error.mp3') }}');
            errorSound.play();
            toastr.error('{{ session('error') }}', 'Error');
        @endif
    </script>


    <script>
        toastr.options = {
            "closeButton": true, // Show close button
            "progressBar": true, // Show progress bar
            "positionClass": "toast-top-right", // Position the toast in the top right
            "timeOut": "5000", // Toast will disappear after 5 seconds
            "extendedTimeOut": "1000", // Extended time for closing the toast after hover
        };
    </script>


    <script>
        function changeStatus(status, userId) {
            $.ajax({
                url: `/user/change-status/${userId}`,
                type: 'POST',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        if (status === 'reject') {
                            // Redirect to dashboard if the status is 'reject'
                            toastr.success('User rejected and account deleted. Redirecting to dashboard...',
                                'Success', {
                                    closeButton: true,
                                    progressBar: true
                                });
                            setTimeout(function() {
                                window.location.href = '{{ route('admin.dashboard') }}';
                            }, 2000); // Wait 2 seconds before redirecting
                        } else {
                            // For other statuses, just reload the page
                            toastr.success(`User status changed to ${status}`, 'Success', {
                                closeButton: true,
                                progressBar: true
                            });
                            location.reload();
                        }
                    } else {
                        toastr.error('Error changing status', 'Error', {
                            closeButton: true,
                            progressBar: true
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error('Something went wrong!', 'Error', {
                        closeButton: true,
                        progressBar: true
                    });
                }
            });
        }
    </script>

    <script>
        $(function() {
            $(".knob").knob();
        });
    </script>


    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            })
        }
    </script>


</body>
</body>

</html>
