<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =  \App\Models\User::pluck('id');

        $users->each(function ($id) {
            \App\Models\Follower::factory(rand(300, 500))->afterCreating(function ($model) {
                $model->event()->create([
                    'user_id' => $model->user_id,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                ]);
            })->create([
                'user_id' => $id
            ]);
        });
    }
}
