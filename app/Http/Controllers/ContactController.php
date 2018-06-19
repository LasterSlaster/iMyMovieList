<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContactController - Controller for contact requests.
 *
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{

    /**
     * Send an email with requested content
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|max:1500'
        ]);

        ContactUs::created($request->all());

        Mail::send('emails.contact_message',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message) use($request) {
                $message->from($request->email, $request->name);
                $message->to('imymovielist@gmx.de', 'Admin')->subject('Imymovielist_contact_request');
            });

        return response()->json([
            'message' => 'Thank you for contacting us!'
        ], 200);
    }
}
