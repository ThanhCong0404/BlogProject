<?php

const ROOT_DIR = __DIR__ . '/..';

function query(string $query, array $data = []): array
{
    $dsn = "mysql:hostname=" . DB_HOST . ";dbname=" . DB_NAME;
    $con = new PDO($dsn, DB_USER, DB_PASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stm = $con->prepare($query);
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        return $result;
    }

    return [];
}

// ... other functions ...

function query_row(string $query): array|false
{
    $dsn = "mysql:hostname=" . DB_HOST . ";dbname=" . DB_NAME;
    $con = new PDO($dsn, DB_USER, DB_PASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stm = $con->prepare($query);
    $stm->execute();

    return $stm->fetch(PDO::FETCH_ASSOC);
}

// ... other functions ...

function create_tables(): void
{
    $dsn = "mysql:hostname=" . DB_HOST;
    $con = new PDO($dsn, DB_USER, DB_PASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "create database if not exists " . DB_NAME;
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "use " . DB_NAME;
    $stm = $con->prepare($query);
    $stm->execute();

    // ... other create table queries ...
}
