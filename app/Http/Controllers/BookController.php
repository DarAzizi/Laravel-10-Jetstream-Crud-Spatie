<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Book::class);

        $search = $request->get('search', '');

        $books = Book::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.books.index', compact('books', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Book::class);

        return view('app.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Book::class);

        $validated = $request->validated();

        $book = Book::create($validated);

        return redirect()
            ->route('books.edit', $book)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Book $book): View
    {
        $this->authorize('view', $book);

        return view('app.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Book $book): View
    {
        $this->authorize('update', $book);

        return view('app.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BookUpdateRequest $request,
        Book $book
    ): RedirectResponse {
        $this->authorize('update', $book);

        $validated = $request->validated();

        $book->update($validated);

        return redirect()
            ->route('books.edit', $book)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book): RedirectResponse
    {
        $this->authorize('delete', $book);

        $book->delete();

        return redirect()
            ->route('books.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
