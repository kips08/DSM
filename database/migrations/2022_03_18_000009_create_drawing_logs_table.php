<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawing_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->integer('rev');
            $table->json('files');
            $table->dateTime('uploaded_at');
            $table->unsignedBigInteger('uploaded_by');
            $table->dateTime('reviewed_at');
            $table->unsignedBigInteger('reviewed_by');
            $table->text('review_note');
            $table->json('review_files');
            $table->unsignedBigInteger('drawing_id');

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
        Schema::dropIfExists('drawing_logs');
    }
};
