<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class IbadahApi extends ResourceController
{
    protected $format = 'json';

    // GET: /api/ibadah
    public function index()
    {
        $db = \Config\Database::connect();
        $data = $db->table('riwayat_ibadah')
                   ->orderBy('tanggal', 'DESC')
                   ->get()
                   ->getResultArray();

        return $this->respond($data);
    }

    // POST: /api/ibadah
    public function create()
    {
        $input = $this->request->getJSON(true); // auto array
        $tanggal = $input['tanggal'] ?? null;
        $ibadah_default = $input['ibadah_default'] ?? [];
        $ibadah_custom = $input['ibadah_custom'] ?? [];
        $note = $input['note'] ?? null;

        $semua = array_merge($ibadah_default, $ibadah_custom);
        $total = count($semua);

        $data = [
            'tanggal'         => $tanggal,
            'ibadah_checked'  => json_encode($semua),
            'note'            => $note,
            'total_ibadah'    => $total
        ];

        $db = \Config\Database::connect();
        $db->table('riwayat_ibadah')->insert($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'Tracking berhasil ditambahkan!']);
    }

    // GET: /api/ibadah/{id}
    public function show($id = null)
    {
        $db = \Config\Database::connect();
        $data = $db->table('riwayat_ibadah')->getWhere(['id' => $id])->getRowArray();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data);
    }

    // DELETE: /api/ibadah/{id}
    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $data = $db->table('riwayat_ibadah')->getWhere(['id' => $id])->getRow();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $db->table('riwayat_ibadah')->delete(['id' => $id]);
        return $this->respondDeleted(['status' => 'success', 'message' => 'Data berhasil dihapus!']);
    }
}
