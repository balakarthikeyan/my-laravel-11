<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\NoteStoreRequest;
use App\Exceptions\InvalidNoteException;
use App\Http\Requests\NoteUpdateRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // $notes = Note::all();
        $notes = Note::latest()->paginate(5);
        return view('notes.index', compact('notes'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteStoreRequest $request): RedirectResponse
    {
        // Note::create($request->all());
        Note::create($request->validated());
        return redirect()->route('notes.index')
                         ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note): View
    {
        $note = Note::findOrFail($note->id);
        
        if (!$note) {
            throw new InvalidNoteException("Note with ID not found.");
        }

        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note): View
    {
        // $note = Note::findOrFail($id);
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteUpdateRequest $request, Note $note): RedirectResponse
    {
        // $note = Note::findOrFail($id);
        $note->update($request->validated());
        return redirect()->route('notes.index')
                        ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note): RedirectResponse
    {
        // $note = Note::findOrFail($id);
        $note->delete();
        return redirect()->route('notes.index')
                        ->with('success', 'Note deleted successfully');
    }
}
