<?php

namespace App\Models;

use Core\Model;
use PDO;

class Slide extends Model
{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM slides ORDER BY position ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
