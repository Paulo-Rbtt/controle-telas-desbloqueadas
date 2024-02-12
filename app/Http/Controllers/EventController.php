<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('events.register', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'employee' => 'required|exists:users,id'
        ]);

        $imagem = $request->file('image');
        $nome_imagem = time() . '.' . $imagem->getClientOriginalExtension();
        $caminho_imagem = public_path('/imagens');
        $imagem->move($caminho_imagem, $nome_imagem);

        // $base64_imagem = base64_encode(file_get_contents($caminho_imagem . '/' . $nome_imagem));

        $evento = new Event();
        $evento->imagem = $nome_imagem;
        $evento->emp_id = $request->employee;
        $evento->user_id = $request->authUser;
        $evento->save();

        return redirect()->route('event.show');
    }

    public function show()
    {
        $events = Event::orderBy('created_at')->get();

        return view('events.list', compact('events'));
    }
}
