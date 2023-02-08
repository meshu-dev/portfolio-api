<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->text('url');
        });

        Schema::create('image_thumbnails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id');
            $table->text('url');

            $table->foreign('image_id')->references('id')->on('images');
        });

        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('name');
            $table->string('description');
            $table->string('url');
            $table->smallInteger('order')->default(0);

            $table->foreign('type_id')->references('id')->on('types');
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

        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('image_id');

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('image_id')->references('id')->on('images');
        });

        Schema::create('prototypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('name');
            $table->string('description');
            $table->string('url');
            $table->smallInteger('order')->default(0);

            $table->foreign('type_id')->references('id')->on('types');
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

        Schema::create('prototype_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prototype_id');
            $table->unsignedBigInteger('image_id');

            $table->foreign('prototype_id')->references('id')->on('prototypes');
            $table->foreign('image_id')->references('id')->on('images');
        });

        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->string('text');
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
        Schema::dropIfExists('image_thumbnails');
        Schema::dropIfExists('repositories');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('types');
        Schema::dropIfExists('prototypes');
        Schema::dropIfExists('prototype_repositories');
        Schema::dropIfExists('prototype_technologies');
        Schema::dropIfExists('prototype_images');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_repositories');
        Schema::dropIfExists('project_technologies');
        Schema::dropIfExists('project_images');
        Schema::dropIfExists('about');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
