<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sections')->truncate();
        factory(\Forum\Models\Section::class, 10)->create();
    }
}
