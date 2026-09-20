@extends('leaute.app')
@section('content')
<h1 class="text-center p-3">Tahkilot qo'shish</h1>
<div class="row">
    <div class="col-md-6">
        <!-- /resources/views/post/create.blade.php -->



@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Create Post Form -->
        <form method="post" action="{{route('companies.store')}}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tahkilot nomi</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Tahkilot manzili</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
             <div class="mb-3">
                <label for="phone" class="form-label">Tahkilot telefon raqami</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</div>


@endsection