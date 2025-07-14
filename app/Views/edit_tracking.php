<!DOCTYPE html>
<html>
<head>
    <title>Edit Tracking Ibadah</title>
    <link rel="stylesheet" href="<?= base_url('css/edit.css') ?>">
</head>
<body>
    <h1>🕊️ Tracking Ibadah Harian</h1>
    <form action="<?= base_url('ibadah/update-tracking/' . $riwayat['id']) ?>" method="post">
<div class="tanggal-display">
  <label for="tanggal">🗓️ Tanggal:</label>
  <span><strong><?= esc($riwayat['tanggal']) ?></strong></span>
</div>
<input type="hidden" name="tanggal" value="<?= esc($riwayat['tanggal']) ?>">
    <h3>✅ Checklist Ibadah Default</h3>
    <div id="ibadahList">
        <?php
            $defaultList = [
                "Subuh" => "Shalat Subuh",
                "Dzuhur" => "Shalat Dzuhur",
                "Ashar" => "Shalat Ashar",
                "Maghrib" => "Shalat Maghrib",
                "Isya" => "Shalat Isya",
                "Ngaji" => "Tilawah Al-Qur'an",
            ];
        ?>

        <?php foreach ($defaultList as $val => $label): ?>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="ibadah_default[]" value="<?= $val ?>"
                        <?= in_array($val, $checked ?? []) ? 'checked' : '' ?>
                        onchange="updateProgress()">
                    <?= $label ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <br>
    <label for="note">📝 Catatan:</label><br>
    <textarea name="note" rows="3" cols="30"><?= esc($riwayat['note']) ?></textarea>

    <br><br>
    <strong>🔄 Progress:</strong>
    <progress id="progressBar" value="0" max="100" style="width: 100%;"></progress>
    <span id="progressText">0%</span>

    <br><br>
    <div class="button-row">
  <a href="<?= base_url('/ibadah') ?>">🔙 Kembali</a>
  <button type="submit">💾 Simpan</button>
</div>
</form>

<script>
    function updateProgress() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const checked = document.querySelectorAll('input[type="checkbox"]:checked');
        const percent = Math.round((checked.length / checkboxes.length) * 100);
        document.getElementById('progressBar').value = percent;
        document.getElementById('progressText').innerText = percent + '%';
    }

    window.onload = updateProgress;
</script>
