<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Messages;
use App\Models\Clients;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $clientIds = $request->input('clients', []);

        if (empty($clientIds)) {
            return Inertia::render('Messages', [
                'clients' => []
            ]);
        }

        $clients = Clients::whereIn('id', $clientIds)->get();

        return Inertia::render('Messages', [
            'clients' => $clients
        ]);
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

    public function sendMessages(Request $request)
    {
        $message = $request->input('message', 'Mensagem padrão');
        $clientIds = $request->input('clients', []);

        if (empty($clientIds)) {
            return response()->json(['error' => 'Nenhum cliente selecionado'], 400);
        }

        $contacts = Client::whereIn('id', $clientIds)->pluck('phone')->toArray();

        foreach ($contacts as $contact) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://localhost:3333/message/text?key=123',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => "id=$contact&message=" . urlencode($message),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        }

        return response()->json(['status' => 'Mensagens enviadas']);
    }
}
