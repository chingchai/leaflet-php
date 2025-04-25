<?php
function pg_connection()
{
    // อ่านค่าจากตัวแปร environment หรือกำหนดตรง ๆ ก็ได้
    $host     = getenv('PGHOST') ?: '5.223.44.146';
    $port     = getenv('PGPORT') ?: '5566';
    $dbname   = getenv('PGDATABASE') ?: 'geodb';
    $user     = getenv('PGUSER') ?: 'postgres';
    $password = getenv('PGPASSWORD') ?: 'USbOtPlenS';

    // สร้าง connection string
    $conn_string = sprintf(
        "host=%s port=%s dbname=%s user=%s password=%s",
        $host,
        $port,
        $dbname,
        $user,
        $password
    );

    // เชื่อมต่อ
    $conn = pg_connect($conn_string);

    if (!$conn) {
        // เชื่อมไม่ติด โยน exception
        throw new Exception('Failed to connect to PostgreSQL: ' . pg_last_error());
    }

    return $conn;
}
