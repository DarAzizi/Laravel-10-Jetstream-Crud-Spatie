<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\BookResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    public function index(Request $request): BookCollection
    {
        $this->authorize('view-any', Book::class);

        $search = $request->get('search', '');

        $books = Book::search($search)
            ->latest()
            ->paginate();

        return new BookCollection($books);
    }

    public function store(BookStoreRequest $request): BookResource
    {
        $this->authorize('create', Book::class);

        $validated = $request->validated();

        $book = Book::create($validated);

        return new BookResource($book);
    }

    public function show(Request $request, Book $book): BookResource
    {
        $this->authorize('view', $book);

        return new BookResource($book);
    }

    public function update(BookUpdateRequest $request, Book $book): BookResource
    {
        $this->authorize('update', $book);

        $validated = $request->validated();

        $book->update($validated);

        return new BookResource($book);
    }

    public function destroy(Request $request, Book $book): Response
    {
        $this->authorize('delete', $book);

        $book->delete();

        return response()->noContent();
    }
}
