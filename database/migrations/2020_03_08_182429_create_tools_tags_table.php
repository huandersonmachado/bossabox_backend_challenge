<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools_tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tool_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();

            $table->foreign('tool_id')->references('id')->on('tools');
            $table->foreign('tag_id')->references('id')->on('tags');
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
        Schema::dropIfExists('tools_tags');
    }
}
