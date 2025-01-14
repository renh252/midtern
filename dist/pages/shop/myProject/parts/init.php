<?php
//  啟動session和匯入

if (! isset($_SESSION)) {
    session_start();
}

require __DIR__ . '/db-connect.php';
