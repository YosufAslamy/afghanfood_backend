<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submitMessage(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contactMessage = new ContactMessage;
        $contactMessage->name = $request->name;
        $contactMessage->email = $request->email;
        $contactMessage->message = $request->message;
        $contactMessage->save();   

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $contactMessage
        ], 201);
    }
}
