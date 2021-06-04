

<x-dashboard-layout title="Add Products">


@if (session()->has('success'))
    <div class="alert alert-success">
        <?= session()->get('success') ?>
    </div>
@endif 

<form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf   
    @include('admin.products._form', [
           'button_lable' => 'Add',
        ])

</form>
</x-dashboard-layout>