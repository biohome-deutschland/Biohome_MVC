<?php

namespace Core;

use PDO;
use Exception;

/**
 * Base model
 */
abstract class Model
{
    /**
     * Get the PDO database connection
     *
     * @return PDO
     */
    public static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            try {
                $db = new PDO($dsn, DB_USER, DB_PASS);
                // Throw an Exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo "Database connection failed: " . $e->getMessage();
                exit;
            }
        }

        return $db;
    }
}
