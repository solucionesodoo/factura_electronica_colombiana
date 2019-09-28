<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Mail;
use stdClass;

class EmailController extends Controller
{
    protected function sendEmail()
    {
        $data = new stdClass();
        $data->title = 'chorizos.net';
        $data->invoice = new stdClass();
        $data->invoice->user = new stdClass();
        $data->invoice->user->email = 'a@b.com';
        /* dd($data); */

        Mail::to('q@a.com')->send(new InvoiceMail($data, null));
    }
}