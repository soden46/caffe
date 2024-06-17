<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->decimal('harga', 8, 2)->default(0);
            $table->decimal('harga_lama', 8, 2)->default(0);
            $table->boolean('promo')->default(0);
            $table->string('foto');
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign("id_kategori")->references("id")->on("kategori")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
