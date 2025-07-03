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
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
            <div class="col-xl-12 col-lg-12 "> 
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Thumbnail Photo</h4>
                    </div>
                    <div class="card-body">
                        <!-- File Upload -->
                        <div class="dropzone" id="categoryDropzone">
                            <div class="fallback">
                                <input name="thumbnail" type="file" />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                <h3 class="mt-4">Drop your images here, or <span class="text-primary">click to
                                        browse</span>
                                </h3>
                                <span class="text-muted fs-13">
                                    1600 x 1200 (4:3) recommended. PNG, JPG and GIF files are allowed
                                </span>
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
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-100">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#categoryDropzone", {
    url: "{{ route('admin.categories.store') }}",
    method: "post",
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
        
    },
    paramName: "thumbnail", // important: use array name
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: 10,
    acceptedFiles: "image/*",
    addRemoveLinks: true,
    autoProcessQueue: false,
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    init: function () {
        this.on("addedfile", function (file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]); // only allow 1 file
            }
            uploadedFile = file;
        });

        this.on("removedfile", function () {
            uploadedFile = null;
        });
    }
});

// Submit form manually and include Dropzone files
document.querySelector("#categoryForm").addEventListener("submit", function(e) {
    e.preventDefault();

    if (!uploadedFile) {
        alert("Please upload a thumbnail image.");
        return;
    }

    const form = e.target;
    const formData = new FormData(form);
    formData.append("thumbnail", uploadedFile);


    fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
       .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Success, but no redirect URL provided.');
            }
        })
        .catch(async (error) => {
            let message = 'Upload failed.';
            if (error.json) {
                const err = await error.json();
                message = err.message || 'Upload failed.';
                console.error('Server Error:', err.errors || err);
            } else {
                console.error(error);
            }
            alert(message);
        });
});

</script>
@endpush