<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Setting;

/**
 * Contact controller
 */
class ContactController extends Controller
{
    /**
     * Show the contact form
     *
     * @return void
     */
    public function showAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Generate CSRF token if not exists
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $success = isset($_GET['sent']) && $_GET['sent'] == 1;
        $error = $_SESSION['contact_error'] ?? null;
        $old_values = $_SESSION['contact_old'] ?? [];

        // Clear session data after retrieving
        unset($_SESSION['contact_error']);
        unset($_SESSION['contact_old']);

        $layout_data = Setting::getLayoutData();
        $settings = $layout_data['settings'];
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        View::renderTemplate('Layouts/main.php', [
            'settings' => $settings,
            'layout_data' => $layout_data,
            'activeTheme' => $activeTheme,
            'content_view' => 'Contact/show.php',
            'success' => $success,
            'error' => $error,
            'old_values' => $old_values,
            'csrf_token' => $_SESSION['csrf_token']
        ]);
    }

    /**
     * Process the contact form submission
     *
     * @return void
     */
    public function sendAction()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /kontakt');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Honeypot check (invisible field)
        if (!empty($_POST['website'])) {
            // Spam detected - silently drop
            header('Location: /kontakt?sent=1');
            exit;
        }

        // 2. CSRF Token check
        $token = $_POST['csrf_token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            $_SESSION['contact_error'] = ['general' => 'Sicherheits-Token ungültig. Bitte versuchen Sie es erneut.'];
            $_SESSION['contact_old'] = $_POST;
            header('Location: /kontakt');
            exit;
        }

        // 3. Validation
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        $errors = [];

        if (mb_strlen($name) < 2) {
            $errors['name'] = 'Bitte geben Sie einen gültigen Namen ein (min. 2 Zeichen).';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
        }

        if (mb_strlen($message) < 10) {
            $errors['message'] = 'Die Nachricht muss mindestens 10 Zeichen lang sein.';
        }

        if (!empty($errors)) {
            $_SESSION['contact_error'] = $errors;
            $_SESSION['contact_old'] = $_POST;
            header('Location: /kontakt');
            exit;
        }

        // Retrieve settings for company email
        $layout_data = Setting::getLayoutData();
        $settings = $layout_data['settings'];
        $to = $settings['company_email'] ?? 'info@biohome-filter-material.de';

        // Prepare email
        $mail_subject = 'Neue Kontaktanfrage: ' . ($subject ?: 'Kein Betreff');
        $mail_body = "Name: $name\n";
        $mail_body .= "E-Mail: $email\n";
        $mail_body .= "Telefon: $phone\n\n";
        $mail_body .= "Nachricht:\n$message\n";

        $headers = "From: " . current(explode(',', $to)) . "\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send email
        $mailSent = @mail($to, $mail_subject, $mail_body, $headers);

        if ($mailSent) {
            header('Location: /kontakt?sent=1');
        } else {
            $_SESSION['contact_error'] = ['general' => 'Die E-Mail konnte aufgrund eines Serverfehlers nicht gesendet werden.'];
            $_SESSION['contact_old'] = $_POST;
            header('Location: /kontakt');
        }
        exit;
    }
}
