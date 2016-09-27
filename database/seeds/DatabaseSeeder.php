<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RbacSeeder::class);
        $this->call(COSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(GRCourseSeeder::class);
        $this->call(GRSeeder::class);
        $this->call(CCPSeeder::class);
    }
}
