@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <h2 class="text-center my-3">{{ $article->title }}</h2><br/>
            
            <div class="text-center img-singel-post">
                @if($article->image)
                <img src="{{ asset('images/article/' . $article->image) }}" alt="{{ $article->title }}"
                    class="img-fluid mb-3">
                @else
                <img src="https://source.unsplash.com/1200x400?{{ $article->category->title }}" alt=""
                    class="img-fluid mb-3">
                @endif
            </div>

            <a href="{{ route('category.index') }}"><button type="button" class="btn btn-secondary mb-3">{{
                $article->category->name }}</button></a>
            <div>
                <h5>Created by : {{ $article->user->name }}, {{ $article->created_at->diffForHumans() }}</h5>
            </div>

            <div>
                <p>{{$article->content }}</p>
            </div>

            <div>
                <a href="{{ route('article.index') }}"><button type="button" class="btn btn-primary float-end"><i class="bi bi-arrow-left-circle-fill"></i> Back to articles</button></a>
            </div>
        </div>

    </div>
</div>
@endsection