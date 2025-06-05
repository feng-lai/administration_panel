<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Search;

class SearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Search::factory()
            ->times(50)
            ->create();
    }
}
