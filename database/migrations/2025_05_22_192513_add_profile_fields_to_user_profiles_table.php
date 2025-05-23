<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUserProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            // Evita erro se já existir
            if (!Schema::hasColumn('user_profiles', 'phone')) {
                $table->string('phone')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('user_profiles', 'city')) {
                $table->string('city')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('user_profiles', 'state')) {
                $table->string('state')->nullable()->after('city');
            }

            if (!Schema::hasColumn('user_profiles', 'email')) {
                $table->string('email')->nullable()->after('state');
            }

            if (!Schema::hasColumn('user_profiles', 'social_links')) {
                $table->text('social_links')->nullable()->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['phone', 'city', 'state', 'email', 'social_links']);
        });
    }
}
