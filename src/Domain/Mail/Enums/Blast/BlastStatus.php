<?php

namespace Domain\Mail\Enums\Blast;

enum BlastStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
}