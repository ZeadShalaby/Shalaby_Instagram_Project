@extends('layouts.app')

@section('content')

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="form-group">
<label for="filename">{{ __('Image') }}</label>
<input type="file" class="form-control" name="filename">
</div>
<div class="form-group">
    <label for="body">{{ __('body') }}</label>
    <textarea name="body" id="body" cols="30" rows="5" class="form-control"></textarea>
</div>

<div class="form-groub">
    <button class="btn btn-primary">
        Publish
    </button>
</div>
</form>

@endsection
