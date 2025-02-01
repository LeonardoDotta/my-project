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

    public function edit(Request $request)
    {
        return Inertia::render('ClientsEdit');
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $client = Clients::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        $client->delete(); // Soft delete

        return response()->json(['message' => 'Cliente marcado como deletado!'], 200);
    }
}
