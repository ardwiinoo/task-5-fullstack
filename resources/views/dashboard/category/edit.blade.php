@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-3"><b>Edit Category</b></h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('category.update', $category) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="mx-3 my-3 fs-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                            placeholder="Enter New Category" name="name" required
                            value="{{ old('name') ?? $category->name }}">

                        @error('name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>

                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class=" card-footer ms-3">
                    <button type="submit" class="btn btn-primary">Edit Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection