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

    /**
     * constructor
     */
    public function __construct(public readonly Blast $blast)
    {
    }

     // build() method to build mailables from blast/mailgroup
     public function build()
     {
        // returns a view
     }
}