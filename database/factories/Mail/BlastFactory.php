<?php

namespace Database\Factories\Mail;

use Domain\Mail\Enums\Blast\BlastStatus;
use Domain\Mail\Models\Blast\Blast;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Blast>
 */
class BlastFactory extends Factory
{
    protected $model = Blast::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'subject' => $this->faker->words(2, true),
            'content' => $this->faker->randomHtml(),
            'filters' => [],
            'status' => BlastStatus::Draft,
            'user_id' => User::factory(),
        ];
    }
}
