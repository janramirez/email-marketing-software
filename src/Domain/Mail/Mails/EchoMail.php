<?php

namespace Domain\Mail\Mails;

use Domain\Mail\Models\Blast\Blast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EchoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Blast $blast)
    {
    }

     public function build()
     {
        return $this
         ->subject($this->blast->subject)
         ->view('emails.echo');
     }
}