<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'admins';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('id');
                $table->string('fname')->nullable()->default(null);
                $table->string('mname')->nullable()->default(null);
                $table->string('lname')->nullable()->default(null);
                $table->string('username');
                $table->string('phone');
                $table->string('email');
                $table->string('location')->nullable()->default(null);
                $table->string('gender', 8)->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->tinyInteger('is_online')->default('0');
                $table->tinyInteger('is_active')->default('1');

                $table->unique(["username"], 'admins_username_unique');

                $table->unique(["phone"], 'admins_phone_unique');

                $table->unique(["email"], 'admins_email_unique');
                $table->nullableTimestamps();
            });
        }

        if (!Schema::hasTable('school_admins')) {
            Schema::create('school_admins', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('id');
                $table->unsignedBigInteger('admin_id');
                $table->unsignedBigInteger('school_id');
                $table->timestamps();

                $table->unique(["admin_id", "school_id"], 'school_admins_admin_id_school_id_unique');
                $table->foreign('admin_id', 'school_admins_admin_id_foreign')->references('id')->on('admins')->onDelete('cascade');
                $table->foreign('school_id', 'school_admins_school_id_foreign')->references('id')->on('schools')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
