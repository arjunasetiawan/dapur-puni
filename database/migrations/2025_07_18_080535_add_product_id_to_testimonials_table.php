<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('testimonials', function (Blueprint $table) {
        $table->unsignedBigInteger('product_id')->after('id');
    });
}

public function down()
{
    Schema::table('testimonials', function (Blueprint $table) {
        $table->dropColumn('product_id');
    });
}
};
