@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        @php
            $postDate = new DateTime($post->created_at);
        @endphp
        <div class="col-md-12 single-post">
            <div>
                <a href="/blog/view-post?id={{ $post->post_id }}">
                    @if($postDate->format('Y-m-d') === (new DateTime())->format('Y-m-d'))
                        Today,
                    @else
                        {{ $postDate->format('d.m.Y') . ', ' }}
                    @endif
                    {{ $postDate->format('H:i') . 'h - ' . $post->title }}
                </a>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <p>
                        <a href="/blog/view-post?id={{ $post->post_id }}" style="color: black; text-decoration: none">
                            {{ html_entity_decode(shortenText($post->content, 1000)) }}
                        </a>
                    </p>
                </div>

                <div class="col-md-3">
                    <a href="/blog/view-post?id={{ $post->post_id }}" style="color: black; text-decoration: none">
                        <img src="{{ $post->image }}" alt="{{ $post->title }}" style="max-width: 100%">
                    </a>
                </div>

                <div class="col-md-9">
                    <p>
                        Author:
                        <a href="?author={{ $post->author_id }}">
                            {{ html_entity_decode($post->first_name . ' ' . $post->last_name) }}
                        </a>
                    </p>
                </div>

                <div class="col-md-3">
                    Comments:
                    <a href="/blog/view-post?id={{ $post->post_id }}" style="color: black; text-decoration: none">
                        {{ $post->num_comments }}
                    </a>
                </div>

            </div>
        </div>
    @endforeach

    {!! $paginator !!}
@endsection