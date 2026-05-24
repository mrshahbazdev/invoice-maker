<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessController
{
    public function show(Request $request)
    {
        $business = $request->user()->currentBusiness();
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        return response()->json($business);
    }

    public function update(Request $request)
    {
        $business = $request->user()->currentBusiness();
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        $validated = $request->validate([
            'business_name' => 'sometimes|required|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'business_phone' => 'nullable|string|max:50',
            'business_address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:100',
            'currency' => 'sometimes|required|string|size:3',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($business->logo) {
                Storage::cloud()->delete($business->logo);
            }
            $validated['logo'] = $request->file('logo')->store('business-logos', 'public');
        }

        $business->update($validated);

        return response()->json($business);
    }
}
