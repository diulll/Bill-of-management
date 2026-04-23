<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('user')
                     ->orderByDesc('created_at')
                     ->paginate(30);

        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Note::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('notes.index')
                         ->with('success', 'Pesan berhasil dikirim.');
    }

    public function destroy(Note $note)
    {
        // Hanya pemilik pesan atau admin yang bisa menghapus
        if (auth()->id() !== $note->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Pesan berhasil dihapus.');
    }
}
