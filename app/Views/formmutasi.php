<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-2xl p-8 max-w-3xl w-full mx-auto"
  style="box-shadow: 0 4px 20px rgba(0,0,0,0.3);">

  <h2 class="text-2xl font-bold text-center mb-6">Form Mutasi Perangkat</h2>

  <form action="<?= base_url('/submit') ?>" method="post" class="space-y-4">

    <div>
      <label for="user" class="block font-medium mb-1">Pilih User</label>
      <select name="user" id="user" class="w-full border rounded-lg p-2">
        <option value="">Pilih User</option>
        <option value="user1">Sandiawan</option>
        <option value="user2">Faizin</option>
        <option value="user3">Aryo</option>
      </select>
    </div>

    <div>
      <label for="id_perangkat" class="block font-medium mb-1">Pilih Perangkat (SN)</label>
      <select name="id_perangkat" id="id_perangkat" class="w-full border rounded-lg p-2">
        <option value="">Pilih Perangkat</option>
        <?php foreach ($perangkat as $p): ?>
          <option value="<?= $p['id'] ?>" data-noreg="<?= $p['noreg'] ?>" data-nama="<?= $p['nama'] ?>" data-sn="<?= $p['serial_number'] ?>">
            <?= $p['serial_number'] ?> - <?= $p['nama'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block font-medium mb-1">No Registrasi</label>
      <input type="text" id="noreg" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
    </div>
    <div>
      <label class="block font-medium mb-1">Nama Perangkat</label>
      <input type="text" id="nama_perangkat" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
    </div>

    <div>
      <label for="keterangan" class="block font-medium mb-1">Keterangan</label>
      <textarea name="keterangan" id="keterangan" rows="3" class="w-full border rounded-lg p-2"></textarea>
    </div>

    <div class="text-center">
      <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-full font-semibold transition">
        Submit Mutasi
      </button>
    </div>

  </form>
</div>

<script>
  // Pas pilih perangkat, auto update Noreg & Nama Perangkat
  const perangkatSelect = document.getElementById('id_perangkat');
  const noregInput = document.getElementById('noreg');
  const namaInput = document.getElementById('nama_perangkat');

  perangkatSelect.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    noregInput.value = selected.getAttribute('data-noreg') || '';
    namaInput.value = selected.getAttribute('data-nama') || '';
  });
</script>
<?= $this->endSection() ?>