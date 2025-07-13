<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Clients;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $clientIds = $request->input('clients');

        if (!$clientIds || !is_array($clientIds)) {
            return Inertia::render('Overview', [
                'clients' => [],
                'error' => 'Nenhum cliente foi enviado.'
            ]);
        }

        $clients = Clients::whereIn('id', $clientIds) 
            ->select('id', 'name', 'phone', 'address')
            ->get();

        return Inertia::render('Overview', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
