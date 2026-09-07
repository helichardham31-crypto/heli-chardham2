<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * The meals migration predates ref_id and type, but the Meal model lists both
 * as fillable and AdminController filters on type.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('meals', function (Blueprint $table) {
            if (! Schema::hasColumn('meals', 'ref_id')) {
                $table->string('ref_id')->nullable()->after('name');
            }
            if (! Schema::hasColumn('meals', 'type')) {
                $table->string('type')->nullable()->after('ref_id');
            }
        });
    }

    public function down()
    {
        Schema::table('meals', function (Blueprint $table) {
            foreach (['ref_id', 'type'] as $column) {
                if (Schema::hasColumn('meals', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
