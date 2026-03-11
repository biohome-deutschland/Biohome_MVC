<?php

/**
 * Globale Hilfsfunktionen
 */

if (!function_exists('sanitize_html')) {
    /**
     * Sanitize HTML content using an allowlist of tags.
     *
     * @param string $html
     * @return string
     */
    function sanitize_html($html)
    {
        $allowedTags = '<p><br><strong><em><ul><ol><li><a><h2><h3><h4><blockquote>';
        return strip_tags((string)$html, $allowedTags);
    }
}
