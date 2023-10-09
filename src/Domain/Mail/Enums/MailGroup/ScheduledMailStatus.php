<?php

namespace Domain\Mail\Enums\MailGroup;

enum ScheduledMailStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}