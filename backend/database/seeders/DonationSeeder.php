<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    private array $donationMessages = [
        'Amazing work!',
        'Keep it up!',
        'You are doing great!',
        'I love your work!',
        'You are awesome!',
        'You are the best!',
        'You are the best streamer!',
        'This is the best stream ever!',
        'Thank you for being awesome!',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =  \App\Models\User::pluck('id');

        $users->each(function ($id) {
            \App\Models\Donation::factory(rand(300, 500))->afterCreating(function ($model) {
                $model->event()->create([
                    'user_id' => $model->user_id,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                ]);
            })->create([
                'donation_message' => $this->donationMessages[array_rand($this->donationMessages)],
                'user_id' => $id
            ]);
        });
    }
}
