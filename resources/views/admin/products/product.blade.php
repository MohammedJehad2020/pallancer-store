

<x-dashboard-layout title="Products">

@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

</x-dashboard-layout>