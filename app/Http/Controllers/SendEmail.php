<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestSendingEmail;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Controller
{
    public function index(){
        Mail::to('muchammad.faisal@unisba.ac.id')->send(new TestSendingEmail());
    }
}
