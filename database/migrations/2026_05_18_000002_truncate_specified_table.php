<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('don_vi')->truncate();
        DB::table('phong')->truncate();
        DB::table('chuc_vu')->truncate();
        DB::table('xep_loai')->truncate();
        DB::table('users')->truncate();
        DB::table('ket_qua_muc_a')->truncate();
        DB::table('kqxl_nam')->truncate();
        DB::table('kqxl_nam_ban_ky_so')->truncate();
        DB::table('kqxl_nam_tap_the')->truncate();
        DB::table('kqxl_quy')->truncate();
        DB::table('kqxl_thang')->truncate();
        DB::table('phieu_danh_gia')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: data truncation cannot be reversed.
    }
};
