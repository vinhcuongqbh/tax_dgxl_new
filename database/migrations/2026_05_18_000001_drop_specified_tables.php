<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('ket_qua_muc_a_cuc_truong');
        Schema::dropIfExists('ket_qua_muc_b');
        Schema::dropIfExists('ly_do_diem_cong');
        Schema::dropIfExists('ly_do_diem_tru');
        Schema::dropIfExists('mau01a');
        Schema::dropIfExists('mau01b');
        Schema::dropIfExists('mau01c');
        Schema::dropIfExists('ngach');
        Schema::dropIfExists('phieu_danh_gia_cuc_truong');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reliably recreate dropped tables here.
    }
};
