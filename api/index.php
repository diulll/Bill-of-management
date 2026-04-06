<?php

// 1. Buat struktur folder di dalam /tmp milik Vercel
$compiledViewPath = '/tmp/storage/framework/views';
if (!file_exists($compiledViewPath)) {
    mkdir($compiledViewPath, 0777, true);
}

// 2. Paksa Laravel menggunakan folder /tmp tersebut
$_ENV['VIEW_COMPILED_PATH'] = $compiledViewPath;
putenv('VIEW_COMPILED_PATH=' . $compiledViewPath);

// 3. Lanjutkan ke aplikasi utama
require __DIR__ . '/../public/index.php';