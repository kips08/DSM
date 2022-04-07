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
        Schema::create('drawings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('component_name');
            $table->string('drawing_name');
            $table->string('status');
            $table->integer('rev');
            $table->json('files')->nullable();
            $table->dateTime('uploaded_at');
            $table->unsignedBigInteger('uploaded_by');
            $table->dateTime('reviewed_at');
            $table->unsignedBigInteger('reviewed_by');
            $table->text('review_note');
            $table->json('review_files');
            $table->unsignedBigInteger('request_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drawings');
    }
};
