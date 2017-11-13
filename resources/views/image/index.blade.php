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
                    <a href="{{ route('image.show', ['image' => $image]) }}"
                       class="list-group-item">{{ $image->source_url }}</a>
                @endforeach
            </ul>
            <div class="text-center">
                {{ $images->links() }}
            </div>
        </div>
    </div>
@endsection