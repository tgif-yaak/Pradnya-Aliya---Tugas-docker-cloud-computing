<?php

namespace App\Models;
use CodeIgniter\Model;

class IbadahModel extends Model
{
    protected $table = 'riwayat_ibadah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'nama_ibadah', 'tipe', 'note'];
}
