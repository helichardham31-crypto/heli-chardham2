<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Same shape as meals, but for the staff types (IPCA_staff / pharma_staff)
 * that AdminController routes to the MealStaff model.
 */
return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('meals_staff')) {
            return;
        }

        Schema::create('meals_staff', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->index();
            $table->string('name');
            $table->string('ref_id')->nullable();
            $table->string('type')->nullable();
            $table->string('meal');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meals_staff');
    }
};
