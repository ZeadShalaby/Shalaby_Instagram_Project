@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-dark">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card mb-12 box-shadow" style="max-width: 600px;">
                    <div class="card-header">
                        <div class="media text-muted pt-3" style="direction:  rtl;">
                            @if ($post->user->avatar == 'default.jpg')
                                <img src="{{ asset('images/' . $post->user->avatar) }}" alt="" class="col-sm-2 rounded"
                                    style="margin-right: -3%; max-width: 70px">
                            @else
                                <img src="{{ asset('images/users/' . $post->user->avatar) }}" alt=""
                                    class="col-sm-2 rounded" style="margin-right: -3%; max-width: 70px">
                            @endif
                            <div class="media-body pb-3 mb-0" style="text-align: right;direction:  rtl;">
                                <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->user->username }}
                                </p>
                            </div>
                            <div class="">
                                @auth
                                    @if ($post->user_id == auth()->user()->id)
                                        <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)"
                                            onclick="if (confirm('{{ __('R_u_sure') }}')) { document.getElementById('delete-{{ $post->id }}').submit(); } else { return false; }"
                                            style="text-decoration: none">
                                            {{ __('Delete') }}
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="post"
                                            id="delete-{{ $post->id }}" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            @can('update', $post)
                                <form action="{{ route('posts.destroy', $post->id) }}" method="post" id="ajax_unlike">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-secondary">{{ __('Delete') }}</button>
                                </form>
                            @endcan
                            <button><a href="{{ route('posts.edit', $post->id) }}">Edit</a></button>
                        </div>
                    </div>
                    <img class="card-img-top" src="{{ asset('images/posts/' . $post->image_path) }}" alt="Card image cap"
                        style="max-height: 600px;">
                    <div class="card-body">
                        <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->body }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>

                    {{-- Start Comment --}}
                    <div class="card-footer" style="direction:  rtl;text-align:  right;">
                        <div class="media text-muted pt-3">

                            @if (auth()->user()->avatar == 'default.jpg')
                                <img src="{{ asset('images/' . auth()->user()->avatar) }}" alt=""
                                    class="col-sm-2 rounded" style="margin-right: -3%; max-width: 70px;max-height: 70px;">
                            @else
                                <img src="{{ asset('images/users/' . auth()->user()->avatar) }}" alt=""
                                    class="col-sm-2 rounded" style="margin-right: -3%; max-width: 70px;max-height: 70px;">
                            @endif

                            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <strong class="text-gray-dark">{{ auth()->user()->name }}</strong>
                                </div>
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" name="comment" class="form-control"
                                                placeholder="{{ __('Add Comment') }}" style="width:  100%;" required
                                                autocomplete="off">
                                            @error('comment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2" style="margin-top: 4px;">
                                            <input type="submit" class="btn btn-sm btn-outline-secondary" name="send"
                                                value="{{ __('Comment') }}">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @foreach ($post->comments as $comment)
                            <div class="media text-muted pt-3">

                                @if ($comment->user->avatar == 'default.jpg')
                                    <img src="{{ asset('images/' . $comment->user->avatar) }}" alt=""
                                        class="col-sm-2 rounded"
                                        style="margin-top:  1%;margin-right: -3%; width: 50px;height: 50px;">
                                @else
                                    <img src="{{ asset('images/users/' . $comment->user->avatar) }}" alt=""
                                        class="col-sm-2 rounded"
                                        style="margin-top:  1%;margin-right: -3%; width: 50px;height: 50px;">
                                @endif
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">{{ $comment->user->username }}</strong><br>
                                        {{--                                            @if ($comment->user->id == auth()->user()->id) --}}
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <input type="submit" class="btn btn-outline-danger"
                                                    value="{{ __('Delete') }}">
                                            </form>
                                        @endcan
                                        {{--                                            @endif --}}
                                    </div>
                                    <span class="text-body"><strong>{{ $comment->comment }}</strong></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script>
        let like = "أعجبني";
        let unlike = "إلغاء الإعجاب";
        let token = '{{ csrf_token() }}';
        let post_id = "{{ $post['id'] }}";
        let like_id = 0;

        @if (sizeof($userLike) == 1)
            like_id = "{{ $userLike[0]->id }}";
        $('#btn_value_id').html(unlike);
        @endif

        function like_action(){

            if( like_id == 0 ){
                $.ajax({
                    type: "POST",
                    url: "{{ url('likes') }}",
                    data: {post_id: post_id, _token: token},
                    success: function( msg ) {
                        $('#count_id').html(msg.count);
                        $('#btn_value_id').html(unlike);
                        like_id = msg.id;
                    }
                });
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('likes') }}/" + post_id,
                    data: { post_id: post_id, _token: token, _method:"DELETE" },
                    success: function( msg ) {
                        $('#count_id').html(msg.count);
                        $('#btn_value_id').html(like);
                        like_id = 0;
                    }
                });
            }
        }

    </script> --}}
@endsection
