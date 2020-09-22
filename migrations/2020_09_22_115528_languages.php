<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Languages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("language");
            $table->string("native");
            $table->string("tag");
            $table->string("code");
            $table->boolean("is_default")->default(false);
            $table->boolean("is_active")->default(false);
            $table->timestamps();
        });

        Schema::create("string_translations", function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('language_id');
            $table->string('t_group');
            $table->string('t_key');
            $table->string('t_value');
            $table->text('translation');
            $table->boolean('is_exported')->default(false);

            $table->foreign('language_id')
                ->references('id')
                ->on("languages")
                ->restrictOnDelete();
        });

        Schema::create("model_translations", function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('language_id');
            $table->foreignId('model_id');
            $table->string('model_class');
            $table->string('model_key');
            $table->text('translation');

            $table->foreign('language_id')
                ->references('id')
                ->on("languages")
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('model_translations');
        Schema::dropIfExists('string_translations');
        Schema::dropIfExists('languages');
        Schema::enableForeignKeyConstraints();
    }
}
