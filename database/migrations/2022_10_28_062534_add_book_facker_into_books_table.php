<?php

use Faker\Factory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddBookFackerIntoBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $faker = Factory::create();

            for ($i = 0; $i < 5000; $i++) {
                DB::table('books')->insert(
                    array(
                        'name' => $faker->realText(rand(20,30)),
                        'author' => $faker->name,
                        'year_published' => $faker->year($max = 'now'),
                    )
                );
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
