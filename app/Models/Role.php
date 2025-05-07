<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';  // Nama tabel roles

    // Menambahkan kolom yang boleh diisi untuk menghindari Mass Assignment
    protected $fillable = ['id', 'name'];

    // Relasi ke model User (seorang Role bisa dimiliki oleh banyak User)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Konstanta untuk mendefinisikan setiap role berdasarkan id
    public const ROLE_ADMIN = 1;
    public const ROLE_PENGADMINISTRASI_UMUM = 2;
    public const ROLE_KASI_PEMBANGUNAN = 3;
    public const ROLE_SEKRETARIS_LURAH = 4;
    public const ROLE_LURAH = 5;
    public const ROLE_KASI_KESEJAHTERAAN_SOSIAL = 7;
    public const ROLE_KASI_PEMERINTAHAN_KETENTRAMAN = 8;
    public const ROLE_USER =9;

    // Method untuk mendapatkan nama role berdasarkan id
    public static function getRoleName($roleId)
    {
        switch ($roleId) {
            case self::ROLE_ADMIN:
                return 'Admin';
            case self::ROLE_PENGADMINISTRASI_UMUM:
                return 'Pengadministrasi Umum';
            case self::ROLE_KASI_PEMBANGUNAN:
                return 'KASI Pembangunan';
            case self::ROLE_SEKRETARIS_LURAH:
                return 'Sekretaris Lurah';
            case self::ROLE_LURAH:
                return 'Lurah';
            case self::ROLE_KASI_KESEJAHTERAAN_SOSIAL:
                return 'KASI Kesejahteraan Sosial';
            case self::ROLE_KASI_PEMERINTAHAN_KETENTRAMAN:
                return 'KASI Pemerintahan Ketentraman';
            case self::ROLE_USER:
                return 'User';
        }
    }
}
