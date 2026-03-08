<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Setting model
 */
class Setting extends Model
{
    /**
     * Get all settings as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT setting_key, setting_value FROM settings');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }
    
    /**
     * Get a specific setting by key
     * 
     * @param string $key
     * @return string|null
     */
    public static function get($key)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT setting_value FROM settings WHERE setting_key = :key LIMIT 1');
        $stmt->bindValue(':key', $key, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['setting_value'] : null;
    }
}
