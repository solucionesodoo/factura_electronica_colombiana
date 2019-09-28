<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fileName;
    public $customer;
    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request, $fileName = null)     
    { 
        $this->fileName = $fileName;
        $this->customer = $request['customer'];
        $this->company  = $request['user'];
    }

    public function build()
    {
        return $this->from($this->company->email)
                    ->markdown('emails.invoice.sent')
                    ->attach(storage_path('app/'.$this->fileName));
    }

}
