<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\ContactUS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact_us()
   {
       return view('admin.contactus.contact_us');
   }
 
   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function contact_us_post(ContactRequest $request)
   {
    //    $this->validate($request, [
    //     'name' => 'required',
    //     'email' => 'required|email',
    //     'message' => 'required'
    //     ]);
 
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
 
       return redirect(route('admin.dashboard'))->with('status', ['type' => 'success', 'message' => __('Thanks For Contacting Us')]);
   }
}
