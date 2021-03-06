@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Image Resize</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('image.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="image_url" class="col-md-4 control-label">Image Url</label>

                                <div class="col-md-6">
                                    <input id="image_url" class="form-control" name="image_url"
                                           value="{{ old('image_url') }}" required autofocus>

                                    @if ($errors->has('image_url'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="num_times" class="col-md-4 control-label">Num Times</label>

                                <div class="col-md-2">
                                    <input id="num_times" class="form-control" name="num_times"
                                           value="{{ old('num_times', 1) }}" required autofocus>

                                    @if ($errors->has('num_times'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('num_times') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
