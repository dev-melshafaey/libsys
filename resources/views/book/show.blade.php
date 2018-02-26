@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>view book details</label>
                </div>

                <div class="panel-body">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Book Name:</label>
                            <div class="col-sm-8">
                                <label >{{$book->name}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Author:</label>
                            <div class="col-sm-8">
                                <label >{{$book->author}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Edition:</label>
                            <div class="col-sm-8">
                                <label>{{$book->edition}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Production Year:</label>
                            <div class="col-sm-8">
                                <label>{{$book->prod_year}}</label>
                            </div>
                        </div>                       
                        @if($book->borrows)
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Borrowed to:</label>
                            <div class="col-sm-8">
                                <label>{{$book->borrows->user->name}}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Email:</label>
                            <div class="col-sm-8">
                                <label>{{$book->borrows->user->email}}</label>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Borrowed Date:</label>
                            <div class="col-sm-8">
                                <label>{{$book->borrows->created_at->format('d-m-Y')}}</label>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-4 control-label text-primary">Retrieve Date:</label>
                            <div class="col-sm-8">
                                <label>{{$book->borrows->created_at->addDays($book->borrows->days)->format('d-m-Y')}}</label>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">                           
                            <div class="col-sm-10">
                                <img height="200" width="200" class="thumbnail" src="{{URL::to('/')}}/storage/books/{{$book->image}}" alt="{{$book->name}}" />                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection