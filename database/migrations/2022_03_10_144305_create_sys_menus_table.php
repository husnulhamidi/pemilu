<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('title',50);
            $table->string('icon')->nullable();
            $table->string('page')->nullable();
            $table->string('bullet')->nullable();
            $table->boolean('arrow')->nullable();
            $table->boolean('root')->nullable();
            $table->enum('is_parent', ['0', '1'])->default('1');
            $table->enum('status_code', ['active', 'inactive','nullified'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            //$table->foreign('parent_id')->references('id')->on('sys_menus')->onUpdate('restrict')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menus');
    }
}
