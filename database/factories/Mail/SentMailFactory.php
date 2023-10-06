<?php

namespace Database\Factories\Mail;

use Domain\Mail\Models\Blast\Blast;
use Domain\Mail\Models\SentMail;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SentMailFactory extends Factory
{
    protected $model = SentMail::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sendable_id' => Blast::factory(),
            'sendable_type' => Blast::class,
            'subscriber_id' => Subscriber::factory(),
            'sent_at' => now(),
        ];
    }
}
