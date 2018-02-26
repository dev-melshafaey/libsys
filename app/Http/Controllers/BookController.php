<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\BookBorrow;

class BookController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (auth()->user()->id === 1) {
            return view('book.create');
        } else {
            return redirect('/')->with('status', 'Not Authorized');
        }
    }

    public function validate_and_upload($request) {
        $this->validate($request, [
            'name' => 'required',
            'author' => 'required',
            'edition' => 'required|numeric',
            'year' => 'required|numeric',
            'image' => 'image|max:2048',
        ]);
        $imagename = null;
        if ($request->file('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/books', $imagename);
        }
        return $imagename;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $imagename = $this->validate_and_upload($request);

        $book = new Book();
        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->edition = $request->input('edition');
        $book->prod_year = $request->input('year');
        $book->image = $imagename;

        $book->save();
        return redirect('/')->with('status', 'Book added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $book = Book::with('borrows.user')->find($id);
        return view('book.show')->with('book', $book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (auth()->user()->id === 1) {
            $book = Book::find($id);
            return view('book.edit')->with('book', $book);
        } else {
            return redirect('/')->with('status', 'Not Authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $book = Book::find($id);
        $imagename = $this->validate_and_upload($request);

        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->edition = $request->input('edition');
        $book->prod_year = $request->input('year');
        if ($imagename) {
            $book->image = $imagename;
        }

        $book->save();
        return redirect('/')->with('status', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $book = Book::find($id);
        $book->delete();
        \Session::flash('status', 'Book deleted successfully!');
        echo json_encode(true);
    }

    public function borrow(Request $request) {
        $count = BookBorrow::where('user_id', auth()->user()->id)->count();
        if ($count < 3) {
            $this->validate($request, [
                'days' => 'numeric|required',
                'id' => 'numeric|required'
            ]);

            $borrow = new BookBorrow();
            $borrow->user_id = auth()->user()->id;
            $borrow->book_id = $request->input('id');
            $borrow->days = $request->input('days');

            $borrow->save();
            echo true;
        } else {
            echo 0;
        }
    }

    public function retrieve($id) {
        $book_borrow = BookBorrow::where(array('user_id' => auth()->user()->id, 'book_id' => $id));
        $book_borrow->delete();
        \Session::flash('status', 'Book retrieved successfully!');
        echo json_encode(true);
    }

}
