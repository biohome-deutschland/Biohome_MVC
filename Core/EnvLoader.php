<?php

namespace Core;

/**
 * Simple .env File Loader
 * 
 * Reads a .env file and sets the values as environment variables.
 * This allows sensitive configuration to be kept out of version control.
 */
class EnvLoader
{
    /**
     * Load the .env file from the given path.
     *
     * @param string $path Path to the .env file (directory, not filename)
     * @return void
     */
    public static function load(string $path): void
    {
        $file = rtrim($path, '/\\') . '/.env';

        if (!file_exists($file)) {
            return; // .env is optional (e.g. when using real environment variables in production)
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            // Split on first '=' only
            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);

            // Remove surrounding quotes if present
            if (preg_match('/^"(.*)"$/', $value, $m) || preg_match("/^'(.*)'$/", $value, $m)) {
                $value = $m[1];
            }

            // Only set if not already defined (real env vars take precedence)
            if (!array_key_exists($key, $_ENV) && !array_key_exists($key, $_SERVER)) {
                putenv("$key=$value");
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}
