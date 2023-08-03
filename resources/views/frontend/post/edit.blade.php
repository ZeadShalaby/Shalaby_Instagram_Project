@extends('layouts.app')

@section('content')

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <div class="pb-2">
                <img src="{{asset('images/posts/'.$post->image_path)}}" style="width: 30%;height:  150px;">
            </div>
            <label for="filename">{{ __('Image') }}</label>
            <input type="hidden" name="filename" value="{{ $post->image_path }}">
            @error('filename')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="body">{{ __('Content') }}</label>
            <textarea class="form-control" name="body" id="body" cols="30" rows="5">{{ old('body', $post->body) }}</textarea>
            @error('body')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block">{{ __('Update') }}</button>
        </div>

    </form>

@endsection





