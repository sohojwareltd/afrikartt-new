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
        Schema::create('shops', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique()->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->text('description');
            $table->text('short_description');
            $table->json('tags');
            $table->text('terms')->nullable();
            $table->string('company_name');
            $table->string('company_registration');
            $table->string('city');
            $table->string('state');
            $table->string('post_code')->nullable();
            $table->json('social_links')->nullable();
            $table->string('country');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('shops');
    }
};
