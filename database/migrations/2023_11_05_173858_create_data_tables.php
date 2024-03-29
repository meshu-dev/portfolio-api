<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('url');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('image_thumbnails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id');
            $table->text('url');

            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        });

        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('url');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('type_id');
            $table->string('name');
            $table->string('description');
            $table->string('url');
            $table->smallInteger('order')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
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

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('text');
            $table->date('employment_start_date');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('images');
        Schema::dropIfExists('image_thumbnails');
        Schema::dropIfExists('repositories');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('types');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_repositories');
        Schema::dropIfExists('project_technologies');
        Schema::dropIfExists('project_images');
        Schema::dropIfExists('profiles');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
