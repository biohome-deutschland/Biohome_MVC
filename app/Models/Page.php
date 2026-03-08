<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Page model
 */
class Page extends Model
{
    /**
     * Get a page by its slug
     *
     * @param string $slug The page slug
     *
     * @return mixed Array of page data if found, false otherwise
     */
    public static function findBySlug($slug)
    {
        $db = static::getDB();
        
        // Check cms_pages first
        try {
            $stmt = $db->prepare('SELECT * FROM cms_pages WHERE slug = :slug LIMIT 1');
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->execute();
            $page = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($page) {
                return $page;
            }
        } catch (\PDOException $e) {
            // Ignore if column/table issues
        }

        // Fallback to pages
        try {
            $stmt = $db->prepare('SELECT * FROM pages WHERE slug = :slug LIMIT 1');
            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }
    
    /**
     * Get all published pages
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM cms_pages WHERE status = "published" ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
