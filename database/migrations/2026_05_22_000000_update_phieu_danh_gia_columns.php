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
        Schema::table('phieu_danh_gia', function (Blueprint $table) {
            $table->dropColumn([
                'diem_tu_cham',
                'diem_cong_tu_cham',
                'diem_tru_tu_cham',
                'tong_diem_tu_cham',
                'diem_danh_gia',
                'diem_cong_danh_gia',
                'diem_tru_danh_gia',
                'tong_diem_danh_gia'
            ]);
        });

        Schema::table('phieu_danh_gia', function (Blueprint $table) {
            $table->decimal('diem_tieu_chi_chung', 4, 1)->nullable()->after('ma_don_vi');
            $table->decimal('diem_thuc_hien_nhiem_vu', 4, 1)->nullable()->after('diem_tieu_chi_chung');
            $table->decimal('tong_diem_tu_cham', 4, 1)->nullable()->after('diem_thuc_hien_nhiem_vu');
            $table->decimal('diem_danh_gia_tieu_chi_chung', 4, 1)->nullable()->after('tong_diem_tu_cham');
            $table->decimal('diem_danh_gia_thuc_hien_nhiem_vu', 4, 1)->nullable()->after('diem_danh_gia_tieu_chi_chung');
            $table->decimal('tong_diem_danh_gia', 4, 1)->nullable()->after('diem_danh_gia_thuc_hien_nhiem_vu');
            $table->text('uu_diem')->nullable()->after('tong_diem_danh_gia');
            $table->text('khuyet_diem')->nullable()->after('uu_diem');
            $table->text('cap_tren_nhan_xet')->nullable()->after('khuyet_diem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phieu_danh_gia', function (Blueprint $table) {
            $table->dropColumn([
                'diem_tieu_chi_chung',
                'diem_thuc_hien_nhiem_vu',
                'tong_diem_tu_cham',
                'diem_danh_gia_tieu_chi_chung',
                'diem_danh_gia_thuc_hien_nhiem_vu',
                'tong_diem_danh_gia',
                'uu_diem',
                'khuyet_diem',
                'cap_tren_nhan_xet'
            ]);
        });

        Schema::table('phieu_danh_gia', function (Blueprint $table) {
            $table->tinyInteger('diem_tu_cham')->nullable()->after('ma_don_vi');
            $table->tinyInteger('diem_cong_tu_cham')->nullable()->after('diem_tu_cham');
            $table->tinyInteger('diem_tru_tu_cham')->nullable()->after('diem_cong_tu_cham');
            $table->tinyInteger('tong_diem_tu_cham')->nullable()->after('tong_diem_tu_cham');
            $table->tinyInteger('diem_danh_gia')->nullable()->after('diem_tru_tu_cham');
            $table->tinyInteger('diem_cong_danh_gia')->nullable()->after('diem_danh_gia');
            $table->tinyInteger('diem_tru_danh_gia')->nullable()->after('diem_cong_danh_gia');
            $table->tinyInteger('tong_diem_danh_gia')->nullable()->after('tong_diem_danh_gia');
        });
    }
};
