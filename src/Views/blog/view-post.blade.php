@extends('layouts.app')

@section('content')
    <!-- post details -->
    <div class="col-md-12 single-post-detail">
        @php
            $postDate = new DateTime($post->created_at);
        @endphp

        @if($postDate->format('Y-m-d') === (new DateTime())->format('Y-m-d'))
            Today,
        @else
            {{ $postDate->format('d.m.Y') . ', ' }}
        @endif
        {{ $postDate->format('H:i') . 'h - ' }}
        <h2>{{ $post->title }}</h2>

        <div style="padding-bottom: 50px">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" style="max-width: 100%">
        </div>

        <div>
            {{ html_entity_decode($post->content) }}
        </div>

        <p><br>
            Author: {{ $post->first_name . ' ' . $post->last_name }}
        </p>
    </div>

    <!-- comments -->
    <div class="col-md-12">
        @foreach($comments as $comment)
            <div style="padding-bottom: 15px">
                {{ html_entity_decode($comment->name) }}
                (
                @php
                    $commentDate = new DateTime($comment->created_at);
                @endphp

                @if($commentDate->format('Y-m-d') === (new DateTime())->format('Y-m-d'))
                    Today,
                @else
                    {{ $postDate->format('d.m.Y') . ', ' }}
                @endif
                {{ $postDate->format('H:i') . 'h' }}
                )

                : {{ html_entity_decode($comment->content) }}

                @if($comment->author_id == @$_SESSION['user_id'])
                    <form style="display: inline" action="/comment/delete" method="post" onsubmit="return confirm('delete comment?')">
                        <input type="hidden" name="comment_id" value="{{ $comment->comment_id }}">
                        <input type="submit" name="delete" value="X">
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    @if(check24UserIsLoggedIn())
        <div class="col-md-12 comment-form">
            <form action="/comment/save" method="post">
                <input type="hidden" name="id" value="{{ $queryString['id'] }}">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name..." id="name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email..." id="email">
                </div>

                <div class="mb-3">
                    <label for="url" class="form-lable">URL</label>
                    <input type="text" name="url" class="form-control" placeholder="URL..." id="url">
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea id="comment" name="comment" class="form-control"></textarea>
                </div>

                <input type="submit" name="submit">
            </form>
        </div>
    @endif
@endsection