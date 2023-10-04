<?php

namespace Database\Factories\Subscriber;

use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FormFactory extends Factory
{

    protected $model = Form::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'content' => $this->faker->randomHtml(),
            'user_id'=>User::factory(),
        ];
    }
}
