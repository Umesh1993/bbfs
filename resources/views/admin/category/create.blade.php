@extends('admin.layouts.app')
@section('title', 'Category')
@php
$topbarText = 'Create Category';
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
@endpush

@section('content')
<div class="container-xxl">
    <div class="row">
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
        <!-- <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="bg-light text-center rounded bg-light">
                        <img src="assets/images/product/p-1.png" alt="" class="avatar-xxl">
                    </div>
                    <div class="mt-3">
                        <h4>Fashion Men , Women & Kid's</h4>
                        <div class="row">
                            <div class="col-lg-4 col-4">
                                <p class="mb-1 mt-2">Created By :</p>
                                <h5 class="mb-0">Seller</h5>
                            </div>
                            <div class="col-lg-4 col-4">
                                <p class="mb-1 mt-2">Stock :</p>
                                <h5 class="mb-0">46233</h5>
                            </div>
                            <div class="col-lg-4 col-4">
                                <p class="mb-1 mt-2">ID :</p>
                                <h5 class="mb-0">FS16276</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <a href="#!" class="btn btn-outline-secondary w-100">Create Category</a>
                        </div>
                        <div class="col-lg-6">
                            <a href="#!" class="btn btn-primary w-100">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-xl-12 col-lg-12 ">

            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Thumbnail Photo</h4>
                    </div>
                    <div class="card-body">
                        <div class="dropzone" id="categoryDropzone">
                            <div class="fallback">
                                <input name="thumbnail" type="file" />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                <h3 class="mt-4">Drop your images here, or <span class="text-primary">click to
                                        browse</span></h3>
                                <span class="text-muted fs-13">1600x1200 recommended. PNG, JPG, GIF allowed.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">General Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="category-title" class="form-label">Category Title</label>
                                    <input type="text" name="title" id="category-title" class="form-control"
                                        placeholder="Enter Title">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="category-title" class="form-label">Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">Main Category</option>
                                        @foreach ($mainCategories as $mainCategory)
                                        <option value="{{ $mainCategory->id }}">{{ $mainCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" name="description" id="description"
                                        rows="7" placeholder="Type description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Meta Options</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta-title" class="form-control"
                                        placeholder="Enter Title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-tag" class="form-label">Meta Tag Keyword</label>
                                    <input type="text" name="meta_keyword" id="meta-tag" class="form-control"
                                        placeholder="Enter word">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" name="meta_description"
                                        id="description" rows="4" placeholder="Type description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-light mb-3 rounded">
                    <div class="row justify-content-end g-2">
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-outline-secondary w-100">Save Change</button>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-primary w-100">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
// Disable auto processing
Dropzone.autoDiscover = false;

const myDropzone = new Dropzone("#categoryDropzone", {
    autoProcessQueue: false,
    uploadMultiple: false,
    maxFiles: 1,
    paramName: "thumbnail",
    acceptedFiles: "image/*",
    addRemoveLinks: true
});

// On submit, append the file manually and submit the form
document.querySelector("#categoryForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    const file = myDropzone.getAcceptedFiles()[0];
    if (!file) {
        alert("Please upload a thumbnail image.");
        return;
    }

    formData.append("thumbnail", file);

    try {
        const response = await fetch(form.action, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            const error = await response.json();
            alert(error.message || "Something went wrong.");
            return;
        }

        const result = await response.json();
        window.location.href = "{{ route('categories.index') }}";

    } catch (error) {
        console.error("Error:", error);
        alert("An unexpected error occurred.");
    }
});

</script>
@endpush