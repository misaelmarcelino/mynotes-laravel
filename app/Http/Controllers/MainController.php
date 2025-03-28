<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Operations;

class MainController extends Controller
{
    public function index()
    {
        // load notes from the user
        $id =  session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        return view('home', [ 'notes' => $notes ]);
    }

    public function newNote()
    {
        return view('new_note');
    }
    public function newNoteSubmit(Request $request)
    {
        // VALIDADE REQUEST
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            // Mensagens de erro
            [
                'text_title.required' => 'O titulo da nota é obrigatório',
                'text_title.min' => 'O titulo deve ter no mínimo :min caracteres',
                'text_title.max' => 'O titulo deve ter no máximo :max caracteres',

                'text_note.required' => 'O corpo da nota é obrigatório',
                'text_note.min' => 'A sua nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A sua nota deve ter no máximo :max caracteres'
            ]
        );

        // GET USER ID
        $id = session('user.id');

        // GREATE NEW NOTE

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->input('text_title');
        $note->content = $request->input('text_note');
        $note->save();

        // REDIRECT TO HOME
        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);

        if ($id === null){
            return redirect()->route('home');
        }
        // load note
        $note = Note::find($id);

        return view('edit_note', [ 'note' => $note ]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            // Mensagens de erro
            [
                'text_title.required' => 'O titulo da nota é obrigatório',
                'text_title.min' => 'O titulo deve ter no mínimo :min caracteres',
                'text_title.max' => 'O titulo deve ter no máximo :max caracteres',

                'text_note.required' => 'O corpo da nota é obrigatório',
                'text_note.min' => 'A sua nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A sua nota deve ter no máximo :max caracteres'
            ]
        );

//        check if note_id Exists
        if($request->note_id == null){
            return redirect()->route('home');
        }
        $id = Operations::decryptId($request->note_id);

        if ($id === null){
            return redirect()->route('home');
        }

        $note = Note::find($id);

        $note->title = $request->input('text_title');
        $note->content = $request->input('text_note');

        $note->save();

        return redirect()->route('home');

    }
    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);

        if ($id === null){
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('delete_note', [ 'note' => $note ]);
    }
    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptId($id);

        if ($id === null){
            return redirect()->route('home');
        }

        $note = Note::find($id);

//        $note->deleted_at = date('Y-m-d H:i:s');
//        $note->save();

        $note->delete();

        return redirect()->route('home');
    }

}
