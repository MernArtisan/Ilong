@extends('admin.layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h6 class="mb-0 text-uppercase ml-3">Privacy Policy</h6>
                </div>
                {{-- <div class="ms-auto"><a href="{{ route('admin.user.create') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"><i
                            class="bx bxs-plus-square"></i>Add New User</a></div> --}}
            </div>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">{{ $privacyPolicy->name ?? '' }}</h4>

                <form method="post" action="{{ route('admin.updatePrivacyPolicy') }}">
                    @csrf <!-- Include this if you are using POST request -->
                    <textarea id="summernote" name="description">
                        {{ old('description', $privacyPolicy->description ?? '') }}
                    </textarea>
                    <br>
                    <button type="submit" class="btn btn-info px-5">Update</button>
                </form>
            </div>
        </div>

    </div>
@endsection
