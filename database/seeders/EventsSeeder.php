<?php

namespace Database\Seeders;

use App\Models\Events;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Events::factory(100)->create();
    }
}
