@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>Dashboard</label>
                    @if(auth()->user()->id === 1)
                    <a href="book/create" class="pull-right btn btn-primary">Add Book</a>
                    @endif
                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif



                    <div class="col-md-12">
                        @if(count($books))
                        @foreach($books->all() as $book)

                        <div class="col-md-3" style="margin: 10px 0;">
                            <a href="book/{{$book->id}}"><img height="300" width="200" class="thumbnail" src="storage/books/{{$book->image}}" alt="{{$book->name}}" /></a>
                            <h4>{{$book->name}}</h4>
                            <label>Author: {{$book->author}}</label><br>
                            <label>Edition: {{$book->edition}}</label>
                            <div>
                                @if(auth()->user()->id === 1)
                                <button onclick="deleteBook({{$book->id}})" class="btn btn-danger">delete</button>
                                <a href="book/{{$book->id}}/edit" class="btn btn-success ">update</a>
                                @endif
                                <button class="btn <?= $book->borrows ? 'btn-inverse' : 'btn-primary' ?>" id="book_{{$book->id}}" 
                                        onclick="<?= ($book->borrows && $book->borrows->user_id === auth()->user()->id) ? 'retrieveBook(' . $book->id . ')' : 'assignId(' . $book->id . ')' ?>" <?= $book->borrows ? '' : 'data-toggle="modal" data-target="#exampleModal"' ?>  
                                        class="btn btn-primary"><?= $book->borrows ? (($book->borrows->user_id === auth()->user()->id) ? 'return' : 'borrowed!') : 'borrow' ?></button>

                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrow a book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label">No. of days</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="noofdays" >
                        <input type="hidden" id="id_hidden">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="borrowBook()" class="btn btn-primary">Borrow!</button>
            </div>
        </div>
    </div>
</div>

<script>

    function assignId(id){
    $('#id_hidden').val(id);
    }

    function retrieveBook(id){
    var will = confirm('Are you sure ?');
    if (will){
    $.ajax({
    url: "book/retrieve/"+id,
            type: 'post',
            dataType: "JSON",
            data:{},
            success: function (response)
            {
            if (response){
                location.reload();
            }
           
            },
            error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            // do something here because of error
            }
    });
    }
    }
    function borrowBook(){
    if ($('#noofdays').val() > 0){
    var id = $('#id_hidden').val();
    $.ajax({
    url: "book/borrow",
            type: 'post',
            dataType: "JSON",
            data:{id:id, days:$('#noofdays').val()},
            success: function (response)
            {
            if (response){

            $('#noofdays').val('');
            $('#book_' + id).html('borrowed!').removeClass('btn-primary').addClass('btn-inverse');
            } else{
            alert('you should not borrow more than 3 books');
            }
            $('#exampleModal').modal('toggle');
            },
            error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            // do something here because of error
            }
    });
    } else{
    alert('You should provide number of days');
    }
    }
    function deleteBook(id){
    var will = confirm('Are you sure ?');
    if (will){
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    }),
            $.ajax({
            url: "book/" + id,
                    type: 'post', // replaced from put
                    dataType: "JSON",
                    data: {
                    "_method": 'DELETE', // method and token not needed in data
                    },
                    success: function (response)
                    {
                    if (response){
                    location.reload();
                    }
                    },
                    error: function(xhr) {
                    console.log(xhr.responseText); // this line will save you tons of hours while debugging
                    // do something here because of error
                    }
            });
    }}
</script>
