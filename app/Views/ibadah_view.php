<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tracking Ibadah Harian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/ibadah.css') ?>">
    <script src="<?= base_url('js/ibadah.js') ?>" defer></script>
</head>
<body>

<!-- NAVBAR HEADER -->
<div class="navbar">
  <div class="user-info">
    👤 Hai, <?= session()->get('username') ?>
  </div>
  <div class="logout-btn">
    <a href="<?= base_url('/logout') ?>">🔓 Logout</a>
  </div>
</div>

<!-- 1. Judul -->
<h1>✨ Tracking Ibadah Harian</h1>

<!-- 2. Statistik -->
<div class="statistik-section">
    <h2 style="text-align:center; color:#4c1d95;">📈 Statistik Ibadah Harian</h2>
    <canvas id="ibadahChart"></canvas> 
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ibadahChart').getContext('2d');

    const ibadahChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($statistik, 'tanggal')) ?>,
            datasets: [{
                label: 'Persentase Ibadah (%)',
                data: <?= json_encode(array_map(fn($s) => round(($s['total_ibadah'] / 6) * 100), $statistik)) ?>,
                borderColor: '#9333ea',
                backgroundColor: 'rgba(147, 51, 234, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Persentase (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                }
            }
        }
    });
</script>

<!-- 3. List Tracking -->
<div class="list-tracking">
    <h2 style="text-align: center;">📌 Riwayat Ibadah</h2>

    <!-- Form Tambah Tracking (pindah ke bawah Riwayat) -->
    <form class="form-tracking-inline" action="<?= base_url('/ibadah/simpan-tracking') ?>" method="post">
        <input type="date" name="tanggal" required>
        <button type="submit"><i class="fas fa-plus"></i> Tambah Ibadah</button>
    </form>

    <?php if (!empty($riwayat)): ?>
        <?php foreach ($riwayat as $item): ?>
            <div class="tracking-card">
                <div class="tanggal">
                    <strong><?= esc($item['tanggal']) ?></strong>
                </div>
                <div class="tracking-actions">
                    <a href="<?= base_url('ibadah/edit-tracking/' . $item['id']) ?>" class="btn-lihat-detail">Lihat Detail</a>
                    <a href="<?= base_url('ibadah/hapus/' . $item['id']) ?>" onclick="return confirm('Yakin mau hapus?')">
                        <i class="fas fa-trash-alt" style="color: #e11d48; margin-left: 10px;"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center;">Belum ada riwayat ibadah</p>
    <?php endif; ?>
</div>


</body>
</html>
