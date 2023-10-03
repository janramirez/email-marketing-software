<?php

namespace Domain\Mail\DataTransferObjects\Blast;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\Enums\Blast\BlastStatus;
use Spatie\LaravelData\Attributes\WithCast;

class BlastData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        public readonly ?FilterData $filters,
        public readonly ?Carbon $sent_at,
        #[WithCast(EnumCast::class)]
        public readonly ?BlastStatus $status = BlastStatus::Draft,
    ) {}


}