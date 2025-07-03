@extends('admin.layouts.app')
@section('title', 'Product')

@php
    $topbarText = 'Edit Product';
    $selectedSizes = $products->variants->pluck('size')->unique()->toArray();
    $selectedColors = $products->variants->pluck('color')->unique()->toArray();
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
@endpush
@section('content')
<div class="container-xxl">

    <div class="row">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form  method="POST" action="{{ route('admin.products.update', $products->id) }}" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PUT')
            <div class="col-xl-12 col-lg-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Product Photo</h4>
                    </div>
                    <div class="card-body">
                        <!-- File Upload -->
                        <div class="dropzone" id="productDropzone">
                            <div class="fallback">
                                <input name="product_images[]" type="file" multiple />
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
                        <h4 class="card-title">Product Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="is-featured" class="form-label">Is Featured</label>
                                    <select name="is_featured" class="form-control">
                                        <option value="1" {{ $products->is_featured == 1 ? 'selected' : '' }}>True</option>
                                        <option value="0" {{ $products->is_featured == 0 ? 'selected' : '' }}>False</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="is-hot-trend" class="form-label">Is Hot Trend</label>
                                    <select name="is_hot_trend" class="form-control">
                                        <option value="1" {{ $products->is_hot_trend == 1 ? 'selected' : '' }}>True</option>
                                        <option value="0" {{ $products->is_hot_trend == 0 ? 'selected' : '' }}>False</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="is-new-arrival" class="form-label">Is New Arrival</label>
                                    <select name="is_new_arrival" class="form-control">
                                        <option value="1" {{ $products->is_new_arrival == 1 ? 'selected' : '' }}>True</option>
                                        <option value="0" {{ $products->is_new_arrival == 0 ? 'selected' : '' }}>False</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="product-name" class="form-label">Product Name</label>
                                    <input type="text" name="name" id="product-name" class="form-control"
                                        placeholder="Items Name" value="{{ old('name', $products->name) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="product-categories" class="form-label">Product Categories</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Main Category</option>
                                        @foreach ($mainCategories as $mainCategory)
                                        <option value="{{ $mainCategory->id }}" {{ old('category_id', $products->category_id) == $mainCategory->id ? 'selected' : '' }}>{{ $mainCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="product-brand" class="form-label">Brand</label>
                                    <select name="brand_id" id="product-brand" class="form-control">
                                        <option value="">-- Select Brand --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="product-stock" class="form-label">Stock</label>
                                    <input type="number" name="stock" id="product-stock" class="form-control"
                                        placeholder="Quantity"  value="{{ old('stock', $products->stock) }}">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="product-price" class="form-label">Price</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="price" id="product-price" class="form-control"
                                        placeholder="000" value="{{ old('price', $products->price) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="product-discount" class="form-label">Discount</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="discount_price" id="product-discount"
                                        class="form-control" placeholder="000" value="{{ old('discount_price', $products->discount_price) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">Size :</h5>
                                    <div class="d-flex flex-wrap gap-2" role="group"
                                        aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" name="sizes[]"  {{ in_array('XS', $selectedSizes) ? 'checked' : '' }} value="XS" class="btn-check"
                                            id="size-xs1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="size-xs1">XS</label>

                                        <input type="checkbox" name="sizes[]"  {{ in_array('S', $selectedSizes) ? 'checked' : '' }} value="S" class="btn-check" id="size-s1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="size-s1">S</label>

                                        <input type="checkbox" name="sizes[]"  {{ in_array('M', $selectedSizes) ? 'checked' : '' }} value="M" class="btn-check" id="size-m1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="size-m1">M</label>

                                        <input type="checkbox" name="sizes[]"  {{ in_array('XL', $selectedSizes) ? 'checked' : '' }} value="XL" class="btn-check"
                                            id="size-xl1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="size-xl1">Xl</label>

                                        <input type="checkbox" name="sizes[]"  {{ in_array('XXL', $selectedSizes) ? 'checked' : '' }} value="XXL" class="btn-check"
                                            id="size-xxl1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="size-xxl1">XXL</label>
                                        <input type="checkbox" name="sizes[]"  {{ in_array('3XL', $selectedSizes) ? 'checked' : '' }} value="3XL" class="btn-check"
                                            id="size-3xl1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="size-3xl1">3XL</label>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mt-3">
                                    <h5 class="text-dark fw-medium">Colors :</h5>
                                    <div class="d-flex flex-wrap gap-2" role="group"
                                        aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" name="colors[]" {{ in_array('Dark', $selectedColors) ? 'checked' : '' }} value="Dark" class="btn-check"
                                            id="color-dark1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-dark1"> <i class="bx bxs-circle fs-18 text-dark"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('Yellow', $selectedColors) ? 'checked' : '' }} value="Yellow" class="btn-check"
                                            id="color-yellow1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-yellow1"> <i
                                                class="bx bxs-circle fs-18 text-warning"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('White', $selectedColors) ? 'checked' : '' }} value="White" class="btn-check"
                                            id="color-white1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-white1"> <i class="bx bxs-circle fs-18 text-white"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('Red', $selectedColors) ? 'checked' : '' }} value="Red" class="btn-check"
                                            id="color-red1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-red1"> <i class="bx bxs-circle fs-18 text-primary"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('Green', $selectedColors) ? 'checked' : '' }} value="Green" class="btn-check"
                                            id="color-green1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-green1"> <i class="bx bxs-circle fs-18 text-success"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('Blue', $selectedColors) ? 'checked' : '' }} value="Blue" class="btn-check"
                                            id="color-blue1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-blue1"> <i class="bx bxs-circle fs-18 text-danger"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('Sky', $selectedColors) ? 'checked' : '' }} value="Sky" class="btn-check"
                                            id="color-sky1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-sky1"> <i class="bx bxs-circle fs-18 text-info"></i></label>

                                        <input type="checkbox" name="colors[]" {{ in_array('Gray', $selectedColors) ? 'checked' : '' }} value="Gray" class="btn-check"
                                            id="color-gray1">
                                        <label
                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                            for="color-gray1"> <i
                                                class="bx bxs-circle fs-18 text-secondary"></i></label>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control bg-light-subtle" name="description" id="description"
                                        rows="7" placeholder="Short description about the product">{{ old('description', $products->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-light mb-3 rounded">
                    <div class="row justify-content-end g-2">
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-outline-secondary w-100">Update Changes</button>
                        </div>
                        <div class="col-lg-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary w-100">Cancel</a>
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

        const dropzone = new Dropzone("#productDropzone", {
            url: "{{ route('admin.products.update', $products->id) }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            },
            paramName: "product_images[]",
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 10,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            autoProcessQueue: false,

            removedfile: function(file) {
                file.previewElement?.remove(); // Remove from preview

                // Skip if not existing image
                if (!file.existing) return;

                // Send delete request
                fetch("{{ route('admin.products.images.delete') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        image_path: file.name,
                        product_id: {{ $products->id }}
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
            }
        });

        @foreach ($products->images as $image)
            const mockFile{{ $image->id }} = {
                name: "{{ basename($image->image_path) }}",
                size: 123456,
                accepted: true,
                status: Dropzone.SUCCESS,
                existing: true
            };

            dropzone.emit("addedfile", mockFile{{ $image->id }});
            dropzone.emit("thumbnail", mockFile{{ $image->id }}, "{{ asset('storage/' . $image->image_path) }}");
            dropzone.emit("complete", mockFile{{ $image->id }});
            dropzone.files.push(mockFile{{ $image->id }});
        @endforeach

        document.querySelector("#productForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            dropzone.getAcceptedFiles().forEach((file, index) => {
                if (!file.existing) {
                    formData.append(`product_images[${index}]`, file);
                }
            });

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