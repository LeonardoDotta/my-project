<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Messages;

class MessagesController extends Controller
{
    public function index()
    {
        return Inertia::render('Messages');
    }

    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        Messages::create([
            'content' => $request->content
        ]);

        return response()->json(['message' => 'Mensagem salva com sucesso!']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
