<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => ['required', 'captcha'],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required|string',
        ]);

        // Send email or handle the form submission logic here
        Mail::raw($request->body, function ($message) use ($request) {
            $message->to(config('mail.contact.email'))
                ->subject('Contact Form Submission')
                ->from($request->email, $request->name);
        });

        return redirect()->route('contact.show')->with('success', 'Your message has been sent.');
    }
}
