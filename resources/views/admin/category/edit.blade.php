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
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Thumbnail Photo</h4>
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
                            <button type="submit" class="btn btn-outline-secondary w-100">Update Change</button>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-100">Cancel</a>
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
Dropzone.autoDiscover = false;

const csrfToken = '{{ csrf_token() }}';
const updateUrl = "{{ route('admin.categories.update', $category->id) }}";
const deleteImageUrl = "{{ route('admin.categories.images.delete') }}";
const categoryId = {{ $category->id }};
const existingThumbnail = "{{ $category->thumbnail }}";

const myDropzone = new Dropzone("#categoryDropzone", {
    url: updateUrl,
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
        'X-HTTP-Method-Override': 'PUT'
    },
    paramName: "thumbnail",
    maxFiles: 1,
    acceptedFiles: "image/*",
    addRemoveLinks: true,
    autoProcessQueue: false,

    removedfile(file) {
        file.previewElement?.remove();

        if (!file.existing) return;

        fetch(deleteImageUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                image_path: file.name,
                category_id: categoryId
            })
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            console.log('Image deleted:', data.message);
        })
        .catch(error => {
            console.error('Delete failed:', error);
        });
    },

    init() {
        if (existingThumbnail) {
            const filename = existingThumbnail.split('/').pop();
            const mockFile = {
                name: filename,
                size: 123456,
                type: 'image/jpeg',
                existing: true
            };

            this.emit("addedfile", mockFile);
            this.emit("thumbnail", mockFile, "{{ asset('storage/' . $category->thumbnail) }}");
            this.emit("complete", mockFile);
            this.files.push(mockFile);
        }
    }
});

document.querySelector("#categoryForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const file = myDropzone.getAcceptedFiles()[0];

    if (file) {
        formData.append("thumbnail", file);
    }

    fetch(updateUrl, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-HTTP-Method-Override': 'PUT',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) throw response;
        return response.json();
    })
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'Updated successfully.');
        }
    })
    .catch(async (error) => {
        let message = 'Update failed.';
        try {
            const err = await error.json();
            message = err.message || message;
            console.error('Validation Errors:', err.errors || err);
        } catch (e) {
            console.error('Unknown error:', error);
        }
        alert(message);
    });
});
</script>
@endpush
