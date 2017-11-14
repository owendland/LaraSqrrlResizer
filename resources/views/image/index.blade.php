@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h3>Current Squirrels
                <small>Click to see images</small>
            </h3>
        </div>
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <ul class="list-group">
                @foreach ($images as $image)
                    <a href="{{ route('image.show', ['image' => $image]) }}" class="list-group-item">
                        <ul class="list-inline">
                            <li>
                                @if (array_get((array)$image->resized_urls, 'thumbnail'))
                                    <img src="{{array_get($image->resized_urls, 'thumbnail.url')}}">
                                @endif
                            </li>
                            <li>
                                <span>Squirrel #{{ $image->id }} - {{ $image->name }}</span>
                            </li>
                            <li class="pull-right text-right">
                                <span class="">
                                    Image Sizes<br/>
                                    {{implode(', ', array_keys((array)$image->resized_urls))}}
                                </span>
                            </li>
                        </ul>
                    </a>
                @endforeach
            </ul>
            <div class="text-center">
                {{ $images->links() }}
            </div>
        </div>
    </div>
@endsection