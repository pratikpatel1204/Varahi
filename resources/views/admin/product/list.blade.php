@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Product List')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h3 class="mb-0">Product List</h3>
                <a href="{{ route('employee.product.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Product
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="ProductTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset($product->image) }}" width="50">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>₹ {{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if ($product->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($product->creator)->name ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('employee.product.edit', $product->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#ProductTable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true
            });
        });
    </script>
@endsection
