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
        Schema::table('product_logins', function (Blueprint $table) {
            $table->string('role')->comment('admin, user')->default('user')->after('password');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_logins', function (Blueprint $table) {
            
            Schema::dropIfExists('product_logins');
        });
    }
};
