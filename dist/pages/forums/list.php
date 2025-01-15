<?php
session_start();
if (isset($_SESSION['admin'])) {
  include __DIR__ . '/post-admin.php';
} else {
  include __DIR__ . '/post-no-admin.php';
}
