<?php

namespace Domain\Mail\ViewModels\Blast;

use Domain\Mail\Mails\EchoMail;
use Domain\Shared\ViewModels\ViewModel;

class PreviewBlastViewModel extends ViewModel
{
    public function __construct(private readonly EchoMail $mail)
    {
    }

    public function subject(): string
    {
        return $this->mail->blast->subject();
    }

    public function content(): string
    {
        return $this->mail->blast->content();
    }
}