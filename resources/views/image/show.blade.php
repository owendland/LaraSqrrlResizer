@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Image #{{$image->id}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Source Url</p>
                    <a href="{{ $image->source_url }}" style="text-overflow: ellipsis">{{ $image->source_url }}</a>

                    @foreach ((array)$image->resized_urls as $name => $resized_url)
                        <p>{{$name}}</p>
                        <p><img src="{{ array_get($resized_url,'url') }}"/></p>
                    @endforeach
                </div>
            </div>
            <div class="text-center">
                <form action="{{ route('image.destroy', ['image' => $image]) }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger">Delete Image</button>
                </form>
            </div>
        </div>
    </div>
@endsection