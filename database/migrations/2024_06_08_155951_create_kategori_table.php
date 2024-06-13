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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->integer('jumlah');
            $table->string('nama_menu')->default('');

            $table->decimal('harga', 8, 2);
            $table->decimal('total', 8, 2);
            $table->boolean('dibayar')->default(0);
            $table->boolean('diantar')->default(0);
            $table->softDeletes();
            $table->foreign("id_user")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('kategori');
    }
};
