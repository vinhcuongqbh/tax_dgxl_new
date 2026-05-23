<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('ket_qua_muc_a')) {
            return;
        }

        DB::statement('ALTER TABLE `ket_qua_muc_a` MODIFY `diem_toi_da` DECIMAL(4,1) NOT NULL');
        DB::statement('ALTER TABLE `ket_qua_muc_a` MODIFY `diem_tu_cham` DECIMAL(4,1) NULL');
        DB::statement('ALTER TABLE `ket_qua_muc_a` MODIFY `diem_danh_gia` DECIMAL(4,1) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('ket_qua_muc_a')) {
            return;
        }

        DB::statement('ALTER TABLE `ket_qua_muc_a` MODIFY `diem_toi_da` TINYINT NOT NULL');
        DB::statement('ALTER TABLE `ket_qua_muc_a` MODIFY `diem_tu_cham` TINYINT NULL');
        DB::statement('ALTER TABLE `ket_qua_muc_a` MODIFY `diem_danh_gia` TINYINT NULL');
    }
};
