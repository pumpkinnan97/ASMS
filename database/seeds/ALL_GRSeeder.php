<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
class ALL_GRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileSystem = new Filesystem();
        $database = $fileSystem->get(base_path('database/seeds') . '/' . 'ALL_GR_infos.sql');
        DB::connection()->getPdo()->exec($database);
    }
}
