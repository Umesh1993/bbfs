@extends('admin.layouts.app')
@section('title', 'Category')
@php
$topbarText = 'Category Edit';
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
        <div class="col-xl-12 col-lg-12 ">

            <div id="preview-template" style="display: none;">
                <div class="dz-preview dz-file-preview">
                    <img data-dz-thumbnail class="img-fluid rounded" />
                    <div class="dz-details">
                        <div class="dz-filename"></div>
                        <div class="dz-size" data-dz-size></div>
                    </div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
            </div>
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
                @method('PUT')
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
                                        placeholder="Enter Title" value="{{ old('title', $category->title) }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="category-title" class="form-label">Parent Category</label>
                                    <select name="parent_id" id="parent_id" class="form-control">
                                        <option value="">-- Select Main Category --</option>
                                        @foreach ($mainCategories as $mainCategory)
                                        <option value="{{ $mainCategory->id }}"
                                            {{ $category->parent_id == $mainCategory->id ? 'selected' : '' }}>
                                            {{ $mainCategory->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" name="description" id="description"
                                        rows="7"
                                        placeholder="Type description">{{ old('description', $category->description) }}</textarea>
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
                                        placeholder="Enter Title"
                                        value="{{ old('meta_title', $category->meta_title) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="meta-tag" class="form-label">Meta Tag Keyword</label>
                                    <input type="text" name="meta_keyword" id="meta-tag" class="form-control"
                                        placeholder="Enter word"
                                        value="{{ old('meta_keyword', $category->meta_keyword) }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-0">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" name="meta_description"
                                        id="description" rows="4"
                                        placeholder="Type description">{{ old('meta_description', $category->meta_description) }}</textarea>
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
// Disable auto discovery to manually initialize Dropzone
Dropzone.autoDiscover = false;

const myDropzone = new Dropzone("#categoryDropzone", {
    url: "#", // not uploading through Dropzone
    autoProcessQueue: false,
    maxFiles: 1,
    acceptedFiles: "image/*",
    paramName: "thumbnail",
    addRemoveLinks: true,
    previewTemplate: document.querySelector('#preview-template').innerHTML,
    init: function() {
        const existingThumbnail = "{{ $category->thumbnail }}";
        if (existingThumbnail) {
            const mockFile = {
                name: existingThumbnail.split('/').pop(),
                size: 123456,
                type: 'image/jpeg',
            };
            this.emit("addedfile", mockFile);
            this.emit("thumbnail", mockFile, "{{ asset('storage/' . $category->thumbnail) }}");
            this.emit("complete", mockFile);
            this.files.push(mockFile);
        }
    }
});

document.querySelector("#categoryForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const file = myDropzone.getAcceptedFiles()[0];

    if (file) {
        formData.append("thumbnail", file);
    }

    fetch(this.action, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = "{{ route('categories.index') }}";
            } else {
                alert("Error occurred.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Upload failed.");
        });
});
</script>
@endpush