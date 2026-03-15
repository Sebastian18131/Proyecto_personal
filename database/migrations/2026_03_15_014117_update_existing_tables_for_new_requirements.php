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
        if (!Schema::hasColumn('dependencies', 'code')) {
            Schema::table('dependencies', function (Blueprint $table) {
                $table->string('code')->nullable()->after('name');
            });
        }

        if (!Schema::hasColumn('files', 'hash')) {
            Schema::table('files', function (Blueprint $table) {
                $table->string('hash')->nullable()->after('path');
                $table->boolean('has_stamp')->default(false)->after('hash');
            });
        }

        if (!Schema::hasColumn('folders', 'year')) {
            Schema::table('folders', function (Blueprint $table) {
                $table->integer('year')->nullable()->after('active');
                $table->boolean('is_closed')->default(false)->after('year');
            });
        }

        if (!Schema::hasColumn('comunications', 'parent_id')) {
            Schema::table('comunications', function (Blueprint $table) {
                $table->foreignId('parent_id')->nullable()->constrained('comunications')->onDelete('cascade')->after('pqr_id');
            });
        }

        if (!Schema::hasTable('app_settings')) {
            Schema::create('app_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');

        Schema::table('comunications', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });

        Schema::table('folders', function (Blueprint $table) {
            $table->dropColumn(['year', 'is_closed']);
        });

        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['hash', 'has_stamp']);
        });

        Schema::table('dependencies', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
