<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmMail;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{


    public function store(Request $request)
    {
        // Get a  Validator for an incoming request
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message'=> 'required',
        ]);

//  sets detail to be the detail collected from the user
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message'=> $request->message,
        ];

        $confirmdetails = [
            'subject' => 'Message successfully Received',
            'name' => $request->name
        ];

        // sends mail to the admin
       $admin = Mail::to('clintononitsha20@gmail.com')->send(new ContactMail($details));
        // sends mail to the user
       $user = Mail::to($details['email'])->send(new ConfirmMail($confirmdetails));


       //return response after mails are sent
       if($admin && $user){
        return response([
            'status'=>'Success'
        ],201);
       }else{
        return response([
            'status'=>'Failed'
        ],401);
       }
    }
}
