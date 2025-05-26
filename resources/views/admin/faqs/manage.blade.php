@extends('admin.layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">FAQS</div>
                <div class="ms-auto"><a href="{{ route('admin.faq.create') }}" class="btn btn-light radius-30 mt-2 mt-lg-0"><i
                            class="bx bxs-plus-square"></i>Add Faq</a></div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($faq) ? route('admin.faq.update', $faq->id) : route('admin.faq.store') }}" method="POST">
                        @csrf
                        @if (isset($faq))
                            @method('PUT')
                        @endif
                        <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping">Q</span>
                            <input type="text" name="question" class="form-control" placeholder="Question"
                                value="{{ isset($faq) ? $faq->question : old('question') }}" aria-label="Username"
                                aria-describedby="addon-wrapping">
                        </div>
                        <br>
                        <div class="input-group flex-nowrap">
                            <textarea name="answer" class="form-control" rows="5" required placeholder="Answer">{{ isset($faq) ? $faq->answer : old('answer') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ isset($faq) && $faq->is_active == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ isset($faq) && $faq->is_active == 0 ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info px-5">{{ isset($faq) ? 'Update' : 'Add' }} FAQ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
