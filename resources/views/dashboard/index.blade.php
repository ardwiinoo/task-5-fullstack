@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <h2 class="text-center my-3"><b>All Article</b></h2><br/>
        <div class="col-md-10">
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

                    <tr>
                        <td>{{Str::limit($article->title, 46) }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article->created_at->diffForHumans() }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('article.show', $article) }}" role="button"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection