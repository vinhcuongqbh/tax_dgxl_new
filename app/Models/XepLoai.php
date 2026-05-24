<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class XepLoai extends Model
{
    use HasFactory;
    protected $table = 'xep_loai';
    protected $primaryKey = 'ma_xep_loai';
    public $incrementing = false;

    public function phieu_danh_gia(): HasMany
    {
        return $this->hasMany(PhieuDanhGia::class, 'ma_xep_loai', 'ma_xep_loai')->withDefault();
    }
}
