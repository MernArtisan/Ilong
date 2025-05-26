<div class="sidebar-wrapper" data-simplebar="true">
 <div class="sidebar-header">
    <div id="logo-container">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('admin/assets/images/bg-themes/abc.png') }}" class="logo-icon"
                id="logo-image" style="width: 126px; margin-left: 39px;" alt="logo icon">
        </a>
    </div>
    <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i></div>
</div>

<script>
    $(document).ready(function() {
        // Toggle sidebar on click of the toggle icon
        $('.toggle-icon').click(function() {
            $('.wrapper').toggleClass('toggled');

            // Check if sidebar is toggled and update logo accordingly
            if ($('.wrapper').hasClass('toggled')) {
                $('#logo-image').css('width', '40px'); // Make the logo smaller
            } else {
                $('#logo-image').css('width', '126px'); // Reset to original size
            }
        });
    });
</script>

   

    <style>
        /* Default logo styling */
        /* Default logo styling */
        .logo-icon {
            width: 130px;
            margin-left: 33px;
            transition: opacity 0.3s ease;
            /* Optional: adds a smooth transition effect */
        }

        /* Hide logo when the sidebar is toggled */
        .wrapper.toggled #logo-container {
            display: none;
        }

        /* Show the logo on hover if the sidebar is active */
        /*.wrapper.toggled:hover #logo-container {*/
        display: block;
        /* Show logo only on hover when sidebar is collapsed */
        /*}*/

        /* Toggle icon styling */
        .toggle-icon {
            margin-top: 10px;
            font-size: 22px;
            cursor: pointer;
            color: #ffffff;
        }
    </style>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"> <i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}">
                <div class="parent-icon"><i class='fas fa-users'></i></div> <!-- Updated icon -->
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.customer.index') }}">
                <div class="parent-icon"><i class='fas fa-user'></i></div> <!-- Updated icon -->
                <div class="menu-title">Customer</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.professionals.index') }}">
                <div class="parent-icon"><i class='fas fa-briefcase'></i></div> <!-- Updated icon -->
                <div class="menu-title">Professionals</div>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.appRequest') }}">
                <div class="parent-icon"><i class='bx bx-message-square-detail'></i></div>
                <div class="menu-title">
                    App Request
                    <span class="badge bg-danger">{{ $appRequestCount }}</span>
                </div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.Contacts') }}">
                <div class="parent-icon"><i class='bx bx-phone'></i></div>
                <div class="menu-title">
                    Contacts
                    <span class="badge bg-danger">{{ $contactNotification->count() }}</span>
                </div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.faq.index') }}">
                <div class="parent-icon"><i class='bx bx-question-mark'></i></div>
                <div class="menu-title">Faqs</div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.privacyPolicy') }}">
                <div class="parent-icon"><i class='bx bx-shield'></i></div>
                <div class="menu-title">Privacy Policy</div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.termCondition') }}">
                <div class="parent-icon"><i class='bx bx-file'></i></div>
                <div class="menu-title">Term & Condition</div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.profile') }}">
                <div class="parent-icon"><i class='bx bx-user'></i></div>
                <div class="menu-title">Profile</div>
            </a>
        </li>

        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="parent-icon"><i class='bx bx-log-out'></i></div>
                <div class="menu-title">Logout</div>
            </a>
            <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

    <!--end navigation-->
</div>
