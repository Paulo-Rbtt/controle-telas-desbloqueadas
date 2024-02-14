<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;

        $usersEvents = User::select(
            'users.name as emp_name', 
            DB::raw('COUNT(events.id) as events_qty'),
            DB::raw('SUM(CASE WHEN events.paid = 0 THEN 1 ELSE 0 END) as unpaid_events'),
            DB::raw('SUM(CASE WHEN events.soda = 1 THEN 1 ELSE 0 END) as soda_events'),
            DB::raw('SUM(CASE WHEN events.soda = 1 AND events.paid = 0 THEN 1 ELSE 0 END) as unpaid_soda_events')
        )
        ->leftJoin('events', 'users.id', '=', 'events.emp_id')
        ->whereMonth('events.created_at', '=', $currentMonth)
        ->groupBy('users.id', 'users.name')
        ->orderBy('events_qty', 'desc')
        ->get();

        return view('dashboard', compact('usersEvents'));
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

        $verifyQty = Event::where('emp_id', $request->employee)->count();

        if($verifyQty >= 2) {
            $withSoda = 1;
        } else {
            $withSoda = 0;
        }

        $imagem = $request->file('image');
        $nome_imagem = time() . '.' . $imagem->getClientOriginalExtension();
        $caminho_imagem = public_path('/imagens');
        $imagem->move($caminho_imagem, $nome_imagem);

        $evento = new Event();
        $evento->imagem = $nome_imagem;
        $evento->emp_id = $request->employee;
        $evento->user_id = $request->authUser;
        $evento->soda = $withSoda;
        $evento->paid = 0;
        $evento->save();

        return redirect()->route('event.show');
    }

    public function show()
    {
        $events = Event::orderBy('created_at')->get();

        return view('events.list', compact('events'));
    }

    public function changeStatusPayment($id)
    {
        $evento = Event::findOrFail($id);
        $evento->paid = $evento->paid == 0 ? 1 : 0;
        $evento->save();
        return response()->json(['message' => 'Status de pagamento alterado com sucesso!']);
    }

    public function destroy($id)
    {
        $evento = Event::findOrFail($id);
        $evento->delete();
        return response()->json(['message' => 'Evento excluído com sucesso!']);
    }
}
