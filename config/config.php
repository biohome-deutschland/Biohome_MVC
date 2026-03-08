<?php

/**
 * Load environment variables from .env file (local development).
 * In production, these can be set directly as real environment variables.
 */
require_once __DIR__ . '/../Core/EnvLoader.php';
\Core\EnvLoader::load(__DIR__ . '/..');

/**
 * Database Configuration
 */
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'biohome_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

/**
 * App Settings
 */
define('APP_URL', getenv('APP_URL') ?: 'http://localhost/Biohome_MVC/Biohome_New_App/public');

/**
 * Admin Credentials
 * Set these in your .env file - NEVER hardcode them here!
 */
define('ADMIN_USERNAME',      getenv('ADMIN_USERNAME')      ?: '');
define('ADMIN_PASSWORD_HASH', getenv('ADMIN_PASSWORD_HASH') ?: '');
