<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Client;
use Illuminate\Http\Request;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $apiKey;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($apiKey)
    {
        $this->apiKey =$apiKey;
   
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $apiKey=$this->apiKey;
        return $this->subject('Mail from Admin')
            ->view('myTestMail',compact('apiKey'));
    }
}
