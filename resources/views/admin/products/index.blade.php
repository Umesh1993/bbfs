@extends('admin.layouts.app')
@section('title', 'Products')
@php
$topbarText = 'Product List';
@endphp

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title flex-grow-1">All Product List</h4>

                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                        Add Product
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
                                        <div class="form-check ms-1">
                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                            <label class="form-check-label" for="customCheck1"></label>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3">Product Name & Size</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Stock</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3">Rating</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($products as $product)
                                    <tr class="border-t">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" value="{{ $product->id }}">
                                        </td>
                                        <td class="px-4 py-3 flex items-center gap-4">
                                            @php
                                                $image = $product->images->first();
                                            @endphp
                                            <img src="{{ asset('storage/' . ($image->image_path ?? 'placeholder.png')) }}" alt="product" width="70px" height="70px" class="w-12 h-12 object-cover rounded" />
                                            <div>
                                                <p class="font-medium">{{ $product->name }}</p>
                                                <span class="text-xs text-gray-500">
                                                    Size: {{ $product->variants->pluck('size')->unique()->implode(' , ') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">{{ getPriceByCurrency($product) }}</td>
                                        <td class="px-4 py-3">
                                            {{ $product->stock }} Item Left<br>
                                            <span class="text-sm text-gray-500">{{ $product->sold ?? 155 }} Sold</span>
                                        </td>
                                        <td class="px-4 py-3">{{ $product->category->title ?? '-' }}</td>
                                        <td class="px-4 py-3 flex items-center gap-2">
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 text-xs font-semibold rounded flex items-center">
                                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                                {{ number_format($product->reviews->avg('rating') ?? 4.5, 1) }}
                                            </span>
                                            <span class="text-sm text-gray-500">{{ $product->reviews->count() }} Review</span>
                                        </td>
                                        <td class="px-4 py-3 flex gap-2">

                                            <div class="d-flex gap-2">
                                        
                                                {{-- Edit Button --}}
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="btn btn-soft-primary btn-sm">
                                                    <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18">
                                                    </iconify-icon>
                                                </a>

                                                {{-- Delete Button --}}
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
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
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection