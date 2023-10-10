<?php

namespace Domain\Mail\Enums\MailGroup;

enum SubscriberStatus: string
{
    case InProgress = 'in-progress';
    case Completed = 'completed';
}