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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('url');
        });

        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('name');
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->smallInteger('order')->default(0);
        });

        Schema::create('project_repositories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('repository_id');

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('repository_id')->references('id')->on('repositories');
        });

        Schema::create('project_technologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('technology_id');

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('technology_id')->references('id')->on('technologies');
        });

        Schema::create('prototypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->smallInteger('order')->default(0);
        });

        Schema::create('prototype_repositories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prototype_id');
            $table->unsignedBigInteger('repository_id');

            $table->foreign('prototype_id')->references('id')->on('prototypes');
            $table->foreign('repository_id')->references('id')->on('repositories');
        });

        Schema::create('prototype_technologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prototype_id');
            $table->unsignedBigInteger('technology_id');

            $table->foreign('prototype_id')->references('id')->on('prototypes');
            $table->foreign('technology_id')->references('id')->on('technologies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('images');
        Schema::dropIfExists('repositories');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('prototypes');
        Schema::dropIfExists('prototype_repositories');
        Schema::dropIfExists('prototype_technologies');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_repositories');
        Schema::dropIfExists('project_technologies');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
