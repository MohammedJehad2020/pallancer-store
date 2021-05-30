<x-dashboard-layout title="Registeration Page">


    @if (session()->has('success'))
    <div class="alert alert-success">
        <?= session()->get('success') ?>
    </div>
    @endif


    <form action="{{ route('infoStore') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="">Name:</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="">Email:</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="">Password:</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-group mb-3">
            <label for="">Gender:</label>
            <div>
                <label>
                    <input type="radio" name="gender" value="male">
                    Male
                </label>
                <label>
                    <input type="radio" name="gender" value="female">
                    Female
                </label>
            </div>
            @error('gender')
            <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="">Birthday:</label>
            <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror">
            @error('birthday')
            <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-group mb-3">
            <label for="">Phone:</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror">
            @error('phone')
            <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-primary" type="submit">save</button>
        </div>

    </form>


</x-dashboard-layout>