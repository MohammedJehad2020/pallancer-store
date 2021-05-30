

<x-dashboard-layout title="Edit Category">

@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<form action="{{ route('admin.categories.update', $id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put') <!-- use to change post method to put method -->

    @include('admin.categories._form', [
           'button_lable' => 'Update',
        ])
</form>

</x-dashboard-layout>