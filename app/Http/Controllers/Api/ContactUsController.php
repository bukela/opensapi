<?php

namespace App\Http\Controllers\Api;

use App\ContactUS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactUsController extends Controller
{
    public function contact_us_post(ContactRequest $request)
    {
        ContactUS::create($request->all());
 
        Mail::send('emails.contactus',
        array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_message' => $request->get('message')
        ), function($message)
         {
             $message->from('opens_site@gmail.com');
             $message->to('opens@admin.com')->subject('Contact Form');
         });
  
        return response(['message' => 'contact form sent']);
    }
}
