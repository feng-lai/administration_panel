<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TagWord;

class TagWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TagWord::factory()
            ->times(50)
            ->create();
    }
}
