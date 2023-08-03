@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-dark">
        <div class="container">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-sm-12 col-xl-4 col-lg-4 col-xl-3">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="{{asset('images/posts/'.$post->image_path)}}" alt="Card image cap" style="height: 250px">
                            <div class="card-body">
                                <p class="card-text">
                                    <small>@ {{$post->user->username}}</small><br>
                                    {{ $post->body }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('posts.show', $post->id) }}">{{ __('Show') }}</a>
                                        {{-- <a class="btn btn-sm btn-outline-secondary" href="#"><i class="text-info fa fa-heart" style="margin-right: 3%;"></i>{{ $post->likes_count }}</a> --}}
                                    </div>
                                    <small class="text-muted">{{ $post->created_at->format('Y-m-d') }}</small>
                                    <div class="media text-muted pt-3">

                                        @if( auth()->user()->avatar == 'default.jpg' )
                                            <img src="{{asset('images/'.auth()->user()->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; max-width: 70px;max-height: 70px;">
                                        @else
                                            <img src="{{asset('images/users/'.auth()->user()->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; max-width: 70px;max-height: 70px;">
                                        @endif

                                        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <strong class="text-gray-dark">{{auth()->user()->name}}</strong>
                                            </div>
                                            <form action="{{ route('comments.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="comment" class="form-control" placeholder="{{ __('Add Comment') }}" style="width:  100%;" required autocomplete="off">
                                                        @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-md-2" style="margin-top: 4px;">
                                                        <input type="submit" class="btn btn-sm btn-outline-secondary" name="send" value="{{ __('Comment') }}">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- {!! $posts->appends(request()->input())->links() !!} --}}
        </div>
    </div>

@endsection

