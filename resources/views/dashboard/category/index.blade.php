@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-3"><b>All Category</b></h2>
    <div class="row justify-content-center">

        @if (session('success'))
        <div class="alert alert-success my-3 text-center" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="col-md-10">
            <a class="btn btn-primary my-3" href="{{ route('category.create') }}" role="button"><i class="bi bi-plus-circle-fill"></i> Create New
                Category</a>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->user->name }}</td>
                        <td>{{ $category->created_at->diffForHumans() }}</td>
                        <td>
                            <form action=" {{ route('category.destroy', $category) }}" method="post"
                                id="form-delete-{{ $category }}">
                                @csrf
                                @method('DELETE')
                            </form>

                            <a class="btn btn-warning" href="{{ route('category.edit', $category) }}"
                                role="button"><i class="bi bi-pencil-fill"></i></a>
                            <a class="btn btn-danger" href="#" role="button"
                                onclick="event.preventDefault();document.getElementById('form-delete-{{ $category}}').submit(); "><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                    @endforeach

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection