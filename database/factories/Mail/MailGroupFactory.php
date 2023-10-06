<?php

namespace Database\Factories\Mail;

use Domain\Mail\Models\MailGroup\MailGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\MailGroup>
 */
class MailGroupFactory extends Factory
{
    protected $model = MailGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
