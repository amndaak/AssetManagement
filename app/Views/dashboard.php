<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-[#e5e9ef] min-h-screen flex items-start p-6 font-sans">

  <!-- Sidebar -->
  <aside class="bg-[#0749ff] text-white w-52 min-h-[90vh] rounded-2xl p-4 flex flex-col shadow-md">
    <a href="#" class="text-xl font-bold mb-6 hover:text-gray-200">MuBa</a>
    <nav class="flex flex-col space-y-3 text-sm font-medium">
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#32a5ff] transition bg-white text-[#0749ff] shadow">
        <i class="fas fa-home text-base"></i> <span>Dashboard</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#32a5ff] transition">
        <i class="fas fa-cubes text-base"></i> <span>Mutasi Barang</span>
      </a>
    </nav>
  </aside>

  <!-- Main -->
  <main class="flex-1 ml-8 flex flex-col">
    <!-- Header -->
    <header class="bg-[#0749ff] text-white rounded-2xl px-6 py-4 flex items-center justify-between shadow-md">
      <div class="font-semibold text-xl">Dashboard</div>
      <div class="flex space-x-6 text-white text-lg items-center">
        <div class="relative">
          <button id="notifButton" class="relative focus:outline-none">
            <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1.5">3</span>
          </button>
          <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white text-black rounded-lg shadow-xl z-50">
            <div class="p-4">
              <h4 class="font-bold text-sm mb-2">Notifikasi Terbaru</h4>
              <p class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>
            </div>
          </div>
        </div>
        <div class="relative">
          <button id="profileButton" class="hover:scale-110 transition-transform duration-200">
            <i class="far fa-user-circle fa-lg"></i>
          </button>
          <div id="profileMenu" class="hidden absolute right-0 mt-5 w-40 bg-[#0749ff] text-white rounded-md shadow-lg z-50">
            <ul class="p-3 space-y-2 font-semibold text-sm">
              <li><a href="#" class="block hover:underline">Dashboard</a></li>
              <li><form method="POST" action="#"><button type="submit" class="w-full text-left hover:underline">Log Out</button></form></li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <!-- Content -->
    <section class="mt-8 bg-white rounded-xl shadow px-6 py-5 w-full">
      <h2 class="text-xl font-semibold mb-4">Event yang Kamu Ikuti</h2>
      <?php if(empty($registeredEvents)): ?>
        <p class="text-gray-500">Belum ada event yang kamu ikuti</p>
      <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach($registeredEvents as $event): ?>
            <?php
              $image = $event['photo'] ?? 'images/default-event.jpg';
              $review = $eventReviews[$event['id']] ?? null;
            ?>
            <div class="bg-white rounded-lg shadow p-4 flex flex-col">
              <img src="<?= $image ?>" alt="<?= $event['title'] ?>" class="rounded mb-3 h-40 w-full object-cover">
              <h3 class="font-semibold text-lg"><?= $event['title'] ?></h3>
              <p class="text-sm text-gray-600"><?= $event['category'] ?></p>
              <p class="text-sm"><?= $event['start_date'] ?> - <?= $event['end_date'] ?></p>
              <p class="text-sm"><?= $event['location'] ?></p>
              <button onclick="togglePresensi('presensi-<?= $event['id'] ?>', true)" class="mt-2 bg-[#4A7CFD] text-white py-1 px-2 rounded">Presensi</button>
              <button onclick="openUlasan('ulasan-<?= $event['id'] ?>')" class="mt-1 bg-gray-200 text-gray-800 py-1 px-2 rounded">Lihat Ulasan</button>

              <!-- Presensi Overlay -->
              <div id="presensi-<?= $event['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg w-96">
                  <h4 class="font-bold mb-4">Presensi <?= $event['title'] ?></h4>
                  <button onclick="togglePresensi('presensi-<?= $event['id'] ?>', false)" class="text-sm text-red-500 hover:underline">Tutup</button>
                </div>
              </div>

              <!-- Ulasan Overlay -->
              <div id="ulasan-<?= $event['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg w-96">
                  <h4 class="font-bold mb-4">Ulasan <?= $event['title'] ?></h4>
                  <?php if($review): ?>
                    <p><?= $review['message'] ?></p>
                  <?php else: ?>
                    <p class="text-gray-500">Belum ada ulasan</p>
                  <?php endif; ?>
                  <button onclick="closeUlasan('ulasan-<?= $event['id'] ?>')" class="text-sm text-red-500 hover:underline">Tutup</button>
                </div>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>
</body>

<script>
function togglePresensi(id, show) {
  const el = document.getElementById(id);
  if(!el) return;
  el.style.display = show ? 'flex' : 'none';
  el.classList.toggle('hidden', !show);
}

function openUlasan(id) {
  const el = document.getElementById(id);
  if(el) { el.style.display = 'flex'; el.classList.remove('hidden'); }
}

function closeUlasan(id) {
  const el = document.getElementById(id);
  if(el) { el.style.display = 'none'; el.classList.add('hidden'); }
}

// Profile & notif dropdown
document.addEventListener('DOMContentLoaded', function () {
  const profileBtn = document.getElementById('profileButton');
  const profileMenu = document.getElementById('profileMenu');
  profileBtn?.addEventListener('click', e => { e.stopPropagation(); profileMenu?.classList.toggle('hidden'); });
  window.addEventListener('click', () => profileMenu?.classList.add('hidden'));

  const notifBtn = document.getElementById('notifButton');
  const notifDropdown = document.getElementById('notifDropdown');
  notifBtn?.addEventListener('click', e => { e.stopPropagation(); notifDropdown?.classList.toggle('hidden'); });
  window.addEventListener('click', () => notifDropdown?.classList.add('hidden'));
});
</script>
