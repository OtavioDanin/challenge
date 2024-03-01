<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**s
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sender');
            $table->uuid('receiver');
            $table->timestamps();

            $table->foreign('sender')->references('id')->on('transfers');
            $table->foreign('receiver')->references('id')->on('transfers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
