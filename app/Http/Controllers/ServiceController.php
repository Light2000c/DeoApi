<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmMail;
use App\Mail\ServiceMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        // Get a  Validator for an incoming request
        $request->validate([
            'service' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'budget' => 'required',
            'duration'=> 'required',
            'address'=> 'required',
        ]);

//  sets detail to be the detail collected from the user
        $details = [
            'service' => $request->service,
            'email' => $request->email,
            'phone' => $request->phone,
            'budget' => $request->budget,
            'duration'=> $request->duration,
            'address'=> $request->address,
        ];

        $confirmdetails = [
            'subject' => 'Message successfully Received',
            'name' => $request->email
        ];

        // sends mail to the admin
       $admin = Mail::to('clintononitsha20@gmail.com')->send(new ServiceMail($details));
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
