<x-dashboard-layout title="Dashboard">

@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif



</x-dashboard-layout>