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

    public function sendMessages(Request $request)
    {
        $contacts = ['5516997899080', '5535992257565'];

        foreach ($contacts as $contact) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'localhost:3333/message/text?key=123',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => "id=$contact&message=Teste",
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
