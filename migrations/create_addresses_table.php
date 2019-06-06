<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->integer('code')->unique()->comment('//区划编码');
            $table->string('name')->comment('//区划名称');
            $table->string('name_pinyin')->nullable()->comment('//区划名称转拼音');

            $table->integer('parent_code')->nullable()->comment('//父级区划编码');

            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
