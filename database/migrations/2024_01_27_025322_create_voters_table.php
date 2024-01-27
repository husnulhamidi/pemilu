<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('telp');
            $table->integer('umur');
            $table->string('status');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('alamat');
            $table->enum('status_code', ['active', 'inactive','nullified'])->default('active');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
}
