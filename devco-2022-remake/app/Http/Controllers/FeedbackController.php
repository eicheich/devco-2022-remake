<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function show()
    {
        return view('feedback.form');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Siapkan data untuk email
        $to = 'devco.houselab@gmail.com';
        $subject = 'Feedback - ' . $request->subject;
        $body = "Name: " . $request->name . "%0D%0A";
        $body .= "Email: " . $request->email . "%0D%0A%0D%0A";
        $body .= "Message:%0D%0A" . str_replace("\n", "%0D%0A", $request->message);

        // Redirect ke Gmail compose
        $gmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" . $to . "&su=" . urlencode($subject) . "&body=" . $body;

        return redirect()->away($gmailUrl);
    }
}
