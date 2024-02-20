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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->double('salary')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
