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
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->unsignedBigInteger('designation_id')->nullable()->after('id');
            $table->unsignedBigInteger('department_id')->nullable()->after('designation_id');
            $table->string('phone_number')->nullable()->after('email');

            // Add foreign key constraints
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraints first
            $table->dropForeign(['designation_id']);
            $table->dropForeign(['department_id']);

            // Drop the columns
            $table->dropColumn('designation_id');
            $table->dropColumn('department_id');
            $table->dropColumn('phone_number');
        });
    }
};
