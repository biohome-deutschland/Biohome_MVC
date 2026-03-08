<?php

namespace App\Models;

use Core\Model;
use PDO;

class Category extends Model
{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM categories ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
