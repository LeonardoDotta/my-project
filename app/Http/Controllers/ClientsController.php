<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Clients;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $clients = Clients::all();
        return Inertia::render('Clients', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        return Inertia::render('ClientsCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $client = Clients::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'message' => 'Cliente criado com sucesso!',
            'client' => $client
        ], 201);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, string $id)
    {
        $client = Clients::findOrFail($id);
        return Inertia::render('ClientsEdit', [
            'client' => $client,
        ]);
    }

    public function update(Request $request, string $id)
    {
        try {
            $client = Clients::findOrFail($id); 
            $client->update($request->all());  
            return response()->json(['message' => 'Cliente atualizado com sucesso', 'client' => $client], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar cliente', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $client = Clients::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Cliente marcado como deletado!'], 200);
    }

    public function toggleStatus(Request $request, Clients $clients)
    {
        $clients->is_client = $request->input('is_client');
        $clients->save();

        return response()->json(['success' => true]);
    }
}
