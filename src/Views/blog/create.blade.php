@extends('layouts.app')

@section('content')
    <div class="col-md-12 comment-form">
        <form action="/blog/save-post" method="post">
            <div class="mb-3">
                <label for="post_title" class="form-label">Post Title</label>
                <input type="text" name="post_title" class="form-control" placeholder="Post Title..." id="post_title">
            </div>

            <div class="mb-3">
                <label for="post_image_link" class="form-label">Post Image Link</label>
                <input type="text" name="post_image_link" class="form-control" placeholder="E.g. https://picsum.photos/1000/400" id="post_image_link">
            </div>

            <div class="mb-3">
                <label for="post_content" class="form-label">Post Content</label>
                <textarea name="post_content" class="form-control" id="post_content"></textarea>
            </div>

            <div>
                <input type="submit" value="Submit" name="submit">
            </div>
        </form>
    </div>

@endsection