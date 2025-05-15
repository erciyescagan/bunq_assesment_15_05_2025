<?php

$migrations = glob(__DIR__ . '/migrations/*.php');


foreach ($migrations as $migration) {
    echo "Running migration: " . basename($migration) . "\n";
    require $migration;
}


