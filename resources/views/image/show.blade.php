@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Image #{{$id}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <img src="{{ $source_url }}"/>

                    @foreach ($resized_urls as $name => $resized_url)
                        <p>{{$name}}</p>
                        <p><img src="{{ array_get($resized_url,'url') }}"/></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection