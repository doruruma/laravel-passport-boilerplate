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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->index()->nullable();
            $table->enum("operation", ["create", "update", "delete", "restore"]);
            $table->string("table_name");
            $table->bigInteger("record_id");
            $table->json("old_data")->nullable();
            $table->json("new_data")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
