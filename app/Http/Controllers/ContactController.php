<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'yourname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'number' => 'required|string|max:255', // Assuming this is phone number
            'message' => 'nullable|string',
        ]);

        Contact::create([
            'yourname' => $request->yourname,
            'email' => $request->email,
            'number' => $request->number,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Thank you for contacting us!');
        // return redirect('/contact')->with('success', 'Thank you for contacting us!');
    }
}
