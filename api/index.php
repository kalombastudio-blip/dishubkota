<?php

/**
 * Vercel Serverless PHP Entry Point untuk Laravel
 */

// Set root project directory
$rootDir = dirname(__DIR__);

// Set DOCUMENT_ROOT ke folder public Laravel
$_SERVER['DOCUMENT_ROOT'] = $rootDir . '/public';

// Pindah ke root project agar Laravel bisa menemukan vendor & bootstrap
chdir($rootDir);

// Bootstrap Laravel
require $rootDir . '/public/index.php';
