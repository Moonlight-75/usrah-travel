<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|in:general,booking,package,complaint,other',
            'package_id' => 'nullable|exists:packages,id',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($validated);

        return redirect()->route('public.contact')->with('success', 'Thank you for contacting us. We will get back to you shortly.');
    }
}
