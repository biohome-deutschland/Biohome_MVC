<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Product model
 */
class Product extends Model
{
    /**
     * Get all visible products
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM products WHERE is_active = 1 ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get a product by its id
     * 
     * @param int $id
     * @return mixed Array of product data if found, false otherwise
     */
    public static function findById($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get featured products (fallback to latest if none)
     *
     * @return array
     */
    public static function getFeatured($limit = 6)
    {
        $db = static::getDB();
        try {
            $stmt = $db->query('SELECT * FROM products WHERE is_featured = 1 AND is_active = 1 ORDER BY id DESC LIMIT ' . (int)$limit);
            $featured = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($featured)) {
                $stmt = $db->query('SELECT * FROM products WHERE is_active = 1 ORDER BY id DESC LIMIT ' . (int)$limit);
                $featured = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $featured;
        } catch (\PDOException $e) {
            $stmt = $db->query('SELECT * FROM products WHERE is_active = 1 ORDER BY id DESC LIMIT ' . (int)$limit);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Get products by category slug
     *
     * @param string $slug
     * @return array
     */
    public static function findByCategorySlug($slug)
    {
        $db = static::getDB();
        $stmt = $db->prepare('
            SELECT p.* FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            JOIN categories c ON pc.category_id = c.id
            WHERE c.slug = :slug AND p.is_active = 1
            ORDER BY p.id DESC
        ');
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get categories for a specific product
     *
     * @param int $product_id
     * @return array
     */
    public static function getCategories($product_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('
            SELECT c.name FROM categories c
            JOIN product_categories pc ON c.id = pc.category_id
            WHERE pc.product_id = :product_id
            ORDER BY c.name ASC
        ');
        $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
