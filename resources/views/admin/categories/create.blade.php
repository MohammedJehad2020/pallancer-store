@extends('layouts.dashboard')

@section('title', 'Create Category')

@section('content')

@if (session()->has('success'))
    <div class="alert alert-success">
        <?= session()->get('success') ?>
    </div>
@endif 

<form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
    @csrf   
    @include('admin.categories._form', [
           'button_lable' => 'Add',
        ])

</form>
@endsection