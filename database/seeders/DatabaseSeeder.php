<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Automation\AutomationSeeder;
use Database\Seeders\Mail\BlastSeeder;
use Database\Seeders\Mail\MailGroupSeeder;
use Database\Seeders\Subscriber\SubscriberSeeder;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const DEMO_USER_EMAIL = 'demo@email.tool';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory([
        //     'first_name' => 'Demo',
        //     'last_name' => 'User',
        //     'email' => self::DEMO_USER_EMAIL,
        //     'password' => Hash::make('password'),
        // ])->create();

        $this->call([
            SubscriberSeeder::class,
            // BlastSeeder::class,
            // MailGroupSeeder::class,
            // AutomationSeeder::class,
        ]);
    }

    protected function demoUser(): User
    {
        return User::whereEmail(self::DEMO_USER_EMAIL)->firstOrFail();
    }

    protected function tagId(string $title): int
    {
        return Tag::whereTitle($title)->firstOrFail()->id;
    }

    protected function formId(string $title): int
    {
        return Form::whereTitle($title)->firstOrFail()->id;
    }
}
