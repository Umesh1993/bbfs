@extends('admin.layouts.app')
@section('title', 'Category')
@php
$topbarText = 'Category List';
@endphp

@section('content')

<div class="container-xxl">
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="rounded bg-secondary-subtle d-flex align-items-center justify-content-center mx-auto">
                        <img src="assets/images/product/p-1.png" alt="" class="avatar-xl">
                    </div>
                    <h4 class="mt-3 mb-0">Fashion Categories</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center mx-auto">
                        <img src="assets/images/product/p-6.png" alt="" class="avatar-xl">
                    </div>
                    <h4 class="mt-3 mb-0">Electronics Headphone</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="rounded bg-warning-subtle d-flex align-items-center justify-content-center mx-auto">
                        <img src="assets/images/product/p-7.png" alt="" class="avatar-xl">
                    </div>
                    <h4 class="mt-3 mb-0">Foot Wares</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="rounded bg-info-subtle d-flex align-items-center justify-content-center mx-auto">
                        <img src="assets/images/product/p-9.png" alt="" class="avatar-xl">
                    </div>
                    <h4 class="mt-3 mb-0">Eye Ware & Sunglass</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">All Categories List</h4>

                    <a href="{{route('admin.categories.create')}}" class="btn btn-sm btn-primary">
                        Add Category
                    </a>

                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            This Month
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Download</a>
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Export</a>
                            <!-- item-->
                            <a href="#!" class="dropdown-item">Import</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover table-centered">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th style="width: 20px;">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                            <label class="form-check-label" for="customCheck1"></label>
                                        </div>
                                    </th>
                                    <th>Main Categories</th>
                                    <th>Categories</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck2">
                                            <label class="form-check-label" for="customCheck2"></label>
                                        </div>
                                    </td>
                                    <td>{{ $category->parent->title ?? '—' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                @if($category->thumbnail &&
                                                Storage::disk('public')->exists($category->thumbnail))
                                                <img src="{{ asset('storage/' . $category->thumbnail) }}"
                                                    alt="Thumbnail" class="avatar-md rounded">
                                                @else
                                                <img src="{{ asset('images/default.png') }}" alt="No Image"
                                                    class="avatar-md rounded">
                                                @endif
                                            </div>
                                            <p class="text-dark fw-medium fs-15 mb-0">{{$category->title}}</p>
                                        </div>
                                    </td>

                                    <td>{{$category->description}}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                    
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="btn btn-soft-primary btn-sm">
                                                <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18">
                                                </iconify-icon>
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
                <div class="card-footer border-top">
                    <div class="d-flex justify-content-end">
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection