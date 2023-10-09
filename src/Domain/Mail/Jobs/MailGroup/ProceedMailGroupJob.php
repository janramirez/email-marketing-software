<?php

namespace Domain\Mail\Jobs\MailGroup;

use Domain\Mail\Actions\MailGroup\ProceedMailGroupAction;
use Domain\Mail\Models\MailGroup\MailGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProceedMailGroupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly MailGroup $mailgroup)
    {
    }

    public function handle()
    {
        ProceedMailGroupAction::execute($this->mailgroup);
    }
}