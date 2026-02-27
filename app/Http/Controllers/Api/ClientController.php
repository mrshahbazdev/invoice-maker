<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController
{
    public function index(Request $request)
    {
        $business = $request->user()->currentBusiness();
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        $clients = Client::where('business_id', $business->id)
            ->withCount('invoices')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $business = $request->user()->currentBusiness();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:100',
        ]);

        $client = $business->clients()->create($validated);

        return response()->json($client, 201);
    }

    public function show(Request $request, Client $client)
    {
        $business = $request->user()->currentBusiness();
        if ($client->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($client->load('invoices'));
    }

    public function update(Request $request, Client $client)
    {
        $business = $request->user()->currentBusiness();
        if ($client->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:100',
        ]);

        $client->update($validated);

        return response()->json($client);
    }

    public function destroy(Request $request, Client $client)
    {
        $business = $request->user()->currentBusiness();
        if ($client->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
}
