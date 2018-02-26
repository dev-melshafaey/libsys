@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>Add new book</label>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{Form::open(array('url' => 'book', 'files' => true, 'method' => 'post')) }}

                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Book Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Author</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="author" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Edition</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="edition" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Production Year</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="year" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Picture</label>
                        <div class="col-sm-10">
                            {!! Form::file('image', array('class' => 'image')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection