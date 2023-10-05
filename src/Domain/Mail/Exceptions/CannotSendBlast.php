<?php

namespace Domain\Mail\Exceptions;

use Exception;

class CannotSendBlast extends Exception
{
    public static function because(string $message): self
    {
        return new self($message);
    }
}