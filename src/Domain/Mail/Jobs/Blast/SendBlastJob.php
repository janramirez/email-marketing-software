<?php

namespace Domain\Mail\Jobs\Blast;

use Domain\Mail\Actions\Blast\SendBlastAction;
use Domain\Mail\Models\Blast\Blast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBlastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Blast $blast)
    {
    }

    public function handle(): void
    {
        SendBlastAction::execute($this->blast);
    }
}
