
<x-dashboard-layout title="Products">


<x-alert />

<div class="table-toolbar mb-3">
    <a href="{{ route('admin.products.create') }}" class="btn btn-info">Create</a>
</div>

<!-- 
@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif -->

<!-- form for filter data -->
<form action="{{ URL::current() }}" method="get" class="d-flex mb-">
    <input name="name" type="text" class="form-control me-2" placeholder="Search by name">
    <select name="parent_id" class="form-control me-2">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>

</form>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Created At</th>           
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td><a href="{{ route('admin.products.edit', $product->id) }}"><?= $product->name ?></a>
        </td>

            <td>{{ $product->category->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links('vendor.pagination.bootstrap-4') }}

</x-dashboard-layout>  


