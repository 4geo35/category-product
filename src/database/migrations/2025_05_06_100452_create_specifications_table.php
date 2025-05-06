<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->string("title")->unique();
            $table->string("slug")->unique();
            $table->string("type")->default("checkbox");
            $table->unsignedBigInteger("group_id")->nullable();
            $table->unsignedBigInteger("priority")->default(0);
            $table->dateTime("in_filter")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
