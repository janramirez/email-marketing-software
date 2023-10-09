<?php

namespace App\Console\Commands\Mail;

use Domain\Mail\Enums\MailGroup\MailGroupStatus;
use Domain\Mail\Jobs\MailGroup\ProceedMailGroupJob;
use Domain\Mail\Models\MailGroup\MailGroup;
use Illuminate\Console\Command;

class ProceedMailGroupCommand extends Command
{
    protected $signature = 'mailgroup:proceed';
    protected $description = 'Send the next mail in the mailgroup';

    public function handle(): int
    {
        $count = MailGroup::with('mails.schedule')
            ->whereStatus(MailGroupStatus::Published)
            ->get()
            ->each( fn (MailGroup $mailgroup) => 
                ProceedMailGroupJob::dispatch($mailgroup)
            )
            ->count();

            $this->info("{$count} scheduled mails are being proceeded");

            return self::SUCCESS;
    }
}
