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
        Schema::table('schedules', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->after('scheduled_at');
            $table->timestamp('end_time')->nullable()->after('start_time');
            $table->string('attachment')->nullable()->after('location');
            $table->dropColumn(['file_path', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dateTime('scheduled_at');
            $table->string('file_path')->nullable();
            $table->dropColumn(['start_time', 'end_time', 'attachment']);
        });
    }
};
