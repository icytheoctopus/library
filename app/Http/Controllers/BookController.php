<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * @return BookResource
     */
    public function index()
    {
        return new BookResource(Book::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'release_date' => 'required|date'
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'min' => 'Minimum :attribute field length is :min',
            'max' => 'Maximum :attribute field length is :min',
            'date' => 'Please enter valid :attribute',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'messages' => $validator->messages(),
            ],422);
        }

        $book = new Book([
            'name' => $request->get('name'),
            'release_date' => $request->get('release_date')
        ]);
        $book->save();

        return response()->json([
            'success' => true,
            'messages' => 'Book successfully created!',
        ]);
    }

    public function createAttach(Request $request){
        $authorData = $request->get('author');
        $author = Author::find($authorData['id']);
        $bookData = $request->get('book');

        $rules = [
            'name' => 'required|min:3|max:50',
            'release_date' => 'required|date'
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'min' => 'Minimum :attribute field length is :min',
            'max' => 'Maximum :attribute field length is :min',
            'date' => 'Please enter valid :attribute',
        ];

        $validator = Validator::make($bookData, $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'messages' => $validator->messages(),
            ],422);
        }

        $book = new Book([
            'name' => $bookData['name'],
            'release_date' => $bookData['release_date'],
        ]);
        $book->save();
        $book->authors()->attach($author);

        return response()->json([
            'success' => true,
            'messages' => 'Book successfully created and attached!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'release_date' => 'required|date'
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'min' => 'Minimum :attribute field length is :min',
            'max' => 'Maximum :attribute field length is :min',
            'date' => 'Please enter valid :attribute',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'messages' => $validator->messages(),
            ],422);
        }

        $book = Book::find($id);
        $book->update($request->all());

        return response()->json([
            'success' => true,
            'messages' => 'Book successfully updated!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Book successfully deleted!',
        ]);
    }
}
