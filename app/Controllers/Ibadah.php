<?php

namespace App\Controllers;

use App\Models\IbadahModel;

class Ibadah extends BaseController
{
    public function index()
{
    $model = new IbadahModel();
    $db = \Config\Database::connect();

    // Ambil data riwayat
    $data['riwayat'] = $model->orderBy('tanggal', 'DESC')->findAll();

    // Ambil data statistik
    $data['statistik'] = $db->table('riwayat_ibadah')
        ->select('tanggal, total_ibadah')
        ->orderBy('tanggal', 'ASC')
        ->get()
        ->getResultArray();

    // Kirim semuanya ke view
    return view('ibadah_view', $data);
}

    public function tambah()
    {
        $model = new IbadahModel();
        $model->save([
            'tanggal'     => $this->request->getPost('tanggal'),
            'nama_ibadah' => $this->request->getPost('nama_ibadah'),
            'status'      => $this->request->getPost('status'),
            'is_default'  => 0,
        ]);
        return redirect()->to('/ibadah');
    }

    public function update($id)
    {
        $model = new IbadahModel();
        $status = $this->request->getPost('status');

        $model->update($id, ['status' => $status]);
        return redirect()->to('/ibadah');
    }

    public function hapus($id)
{
    $db = \Config\Database::connect();

    // Hapus dari tabel riwayat_ibadah
    $db->table('riwayat_ibadah')->delete(['id' => $id]);

    return redirect()->to('/ibadah')->with('success', 'Tracking berhasil dihapus!');
}


    public function simpanTracking()
    {
        $tanggal = $this->request->getPost('tanggal');
        $ibadahDefault = $this->request->getPost('ibadah_default') ?? [];
        $ibadahCustom = $this->request->getPost('ibadah_custom') ?? [];

        $semuaIbadah = array_merge($ibadahDefault, $ibadahCustom);
        $total = count($semuaIbadah);

        $data = [
            'tanggal'         => $tanggal,
            'ibadah_checked'  => json_encode($semuaIbadah),
            'note'            => null,
            'total_ibadah'    => $total
        ];

        $db = \Config\Database::connect();
        $db->table('riwayat_ibadah')->insert($data);

        return redirect()->to('/ibadah')->with('success', 'Tracking berhasil disimpan!');
    }

    public function editTracking($id)
    {
        $db = \Config\Database::connect();

        $riwayat = $db->table('riwayat_ibadah')->getWhere(['id' => $id])->getRowArray();
        if (!$riwayat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data tidak ditemukan");
        }

        $checked = json_decode($riwayat['ibadah_checked'], true) ?? [];

        $ibadahDefault = $db->table('ibadah')->where('is_default', 1)->get()->getResultArray();
        $ibadahCustom = $db->table('ibadah')->where('is_default', 0)->get()->getResultArray();

        return view('edit_tracking', [
            'riwayat' => $riwayat,
            'checked' => $checked,
            'ibadahDefault' => $ibadahDefault,
            'ibadahCustom' => $ibadahCustom
        ]);
    }

    public function updateTracking($id)
{
    $tanggal = $this->request->getPost('tanggal');
    $note = $this->request->getPost('note');

    $ibadahDefault = $this->request->getPost('ibadah_default') ?? [];
    $ibadahCustom = $this->request->getPost('ibadah_custom') ?? [];

    // Gabungkan semua ibadah yang dicentang
    $semuaIbadah = array_merge($ibadahDefault, $ibadahCustom);

    // Hitung total ibadah yang dicentang
    $total = count($semuaIbadah);

    // Buat data yang akan disimpan
    $data = [
        'tanggal'        => $tanggal, // Opsional kalau kamu mau bisa diedit, kalau enggak tinggal dihapus aja field ini
        'ibadah_checked' => json_encode($semuaIbadah),
        'note'           => $note,
        'total_ibadah'   => $total
    ];

    // Update ke database
    $db = \Config\Database::connect();
    $db->table('riwayat_ibadah')->where('id', $id)->update($data);

    // Redirect balik ke halaman utama dengan pesan sukses
    return redirect()->to('/ibadah')->with('success', 'Tracking berhasil diperbarui!');
}



}
