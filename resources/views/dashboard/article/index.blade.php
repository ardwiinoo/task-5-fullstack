@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-3"><b>Article</b></h2>
    <div class="row justify-content-center">

        @if (session('success'))
        <div class="alert alert-success my-3 text-center" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="col-md-10">
            <a class="btn btn-primary my-3" href="{{ route('article.create') }}" role="button"><i class="bi bi-plus-circle-fill"></i> Create New
                Article</a>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Author</th>
                        <th scope="col">Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    @if ($article->user->id == Auth::user()->id)
                    <tr>
                        <td>{{Str::limit($article->title, 46) }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article->created_at->diffForHumans() }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('article.show', $article) }}" role="button"><i class="bi bi-eye-fill"></i></a>
                            <a class="btn btn-warning" href="{{ route('article.edit', $article) }}"
                                role="button"><i class="bi bi-pencil-fill"></i></a>
                            <a class="btn btn-danger" href="#" role="button"
                                onclick="event.preventDefault();document.getElementById('form-delete-{{ $article->id}}').submit();"><i class="bi bi-trash-fill"></i></a>

                            <form action="{{ route('article.destroy', $article->id) }}" method="post"
                                id="form-delete-{{ $article->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection