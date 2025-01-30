<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Operations;

class MainController extends Controller
{
    public function index()
    {
        // load notes from the user
        $id =  session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', [ 'notes' => $notes ]);
    }

    public function newNote()
    {
        return view('new_note');
    }
    public function newNoteSubmit(Request $request)
    {

    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);
    }
    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
    }

}
