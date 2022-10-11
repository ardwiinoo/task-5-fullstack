@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-3"><b>Edit Article</b></h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('article.update', $article) }}" method="post" enctype="multipart/form-data">

                @csrf
                @method('PATCH')

                <div class="mx-3 my-3 fs-3 fw-bold">
                    <label for="title" class="form-label  ">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        placeholder="Enter title" name="title" required value="{{ old('title') ?? $article->title }}">

                    @error('title')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mx-3 my-3 fs-3 fw-bold">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" name="category_id">
                        @foreach ($categories as $category)

                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>

                </div>

                <div class="mx-3 my-3 fs-3 fw-bold">
                    <label for="content" class="form-label">content</label>
                    <textarea name="content" id="content" cols="30"
                        rows="10">{!! old('content') ?? $article->content !!}</textarea>

                </div>

                <div class="mx-3 my-3 fw-bold">
                    <label for="images" class="form-label">images</label>
                    @if ($article->image)
                    <img src="{{ asset('images/article/' . $article->image) }}"
                        class="img-preview img-fluid md-3 col-sm-5 d-block">
                    @else
                    <img class="img-preview img-fluid md-3 col-sm-5 ">
                    @endif
                    <input type="file" class="form-control mt-3" id="image" name="image" onchange="previewImage()">
                    <input type="hidden" name="oldImage" value="{{ $article->image }}">



                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class=" card-footer ms-3">
                    <button type="submit" class="btn btn-primary">Update article</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );

        function previewImage()
        {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            const oFReader = new FileReader();

            oFReader.readAsDataURL(image.files[0]);
            
            oFReader.onload = function(oFREvent)
            {
                imgPreview.src = oFREvent.target.result;
            }
        }
</script>
@endsection