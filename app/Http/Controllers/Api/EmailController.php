<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class EmailController extends Controller

{
    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string',
        ]);

        $details = [
            'title' => 'Mail from ' . $validated['name'],
            'body' => $validated['message'],
            'from' => $validated['email']
        ];

        Mail::send([], [], function ($message) use ($details) {
            $message->to('recipient@example.com')
                ->subject($details['title'])
                ->html($details['body']); // Usa html() invece di setBody()
            $message->from($details['from']);
        });

        return response()->json(['message' => 'Email sent successfully']);
    }
}
