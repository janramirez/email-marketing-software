<?php

namespace Domain\Mail\Enums\MailGroup;

enum MailGroupStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}