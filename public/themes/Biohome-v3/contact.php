<?php
$settings = $settings ?? [];
$contact_email = '';
if (array_key_exists('company_email', $settings)) {
    $contact_email = (string) $settings['company_email'];
} else {
    $contact_email = $settings['admin_email'] ?? '';
    if ($contact_email === '' && defined('ADMIN_USERNAME')) {
        $contact_email = ADMIN_USERNAME;
    }
}
$contact_phone = array_key_exists('company_phone', $settings) ? (string) $settings['company_phone'] : '';
$contact_address = array_key_exists('company_address', $settings) ? (string) $settings['company_address'] : '';
$contact_name = $site_name ?? 'Biohome';

$submit_message = '';
$submit_error = '';
$form_name = '';
$form_email = '';
$form_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    $form_name = trim((string) ($_POST['name'] ?? ''));
    $form_email = trim((string) ($_POST['email'] ?? ''));
    $form_message = trim((string) ($_POST['message'] ?? ''));

    if ($honeypot !== '') {
        $submit_message = 'Danke! Wir melden uns schnellstmoeglich.';
    } elseif ($form_name === '' || $form_email === '' || $form_message === '') {
        $submit_error = 'Bitte alle Felder ausfuellen.';
    } else {
        $submit_message = 'Danke! Wir melden uns schnellstmoeglich.';
    }
}
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Kontakt</p>
        <h1 class="page-title">Wie koennen wir helfen?</h1>
        <p class="page-subtitle">Schreiben Sie uns Ihre Frage oder Anfrage. Wir melden uns schnellstmoeglich zurueck.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div>
                <?php if ($submit_message): ?>
                    <div class="form-message form-message--success"><?php echo e($submit_message); ?></div>
                <?php endif; ?>
                <?php if ($submit_error): ?>
                    <div class="form-message form-message--error"><?php echo e($submit_error); ?></div>
                <?php endif; ?>
                <form action="?page=kontakt" method="post">
                    <div class="form-field">
                        <label for="contact-name">Name</label>
                        <input class="form-control" type="text" id="contact-name" name="name" placeholder="Ihr Name" value="<?php echo e($form_name); ?>">
                    </div>
                    <div class="form-field">
                        <label for="contact-email">E-Mail</label>
                        <input class="form-control" type="email" id="contact-email" name="email" placeholder="name@beispiel.de" value="<?php echo e($form_email); ?>">
                    </div>
                    <div class="form-field">
                        <label for="contact-message">Nachricht</label>
                        <textarea class="form-control" id="contact-message" name="message" rows="6" placeholder="Wie koennen wir helfen?"><?php echo e($form_message); ?></textarea>
                    </div>
                    <div class="form-field honeypot" aria-hidden="true">
                        <label for="contact-website">Website</label>
                        <input class="form-control" type="text" id="contact-website" name="website" autocomplete="off" tabindex="-1">
                    </div>
                    <button class="btn btn-primary" type="submit">Nachricht senden</button>
                </form>
            </div>
            <div class="info-card">
                <h3><?php echo e($contact_name); ?></h3>
                <?php if ($contact_address !== ''): ?>
                    <p><?php echo e($contact_address); ?></p>
                <?php endif; ?>
                <?php if ($contact_email !== ''): ?>
                    <p><a href="mailto:<?php echo e($contact_email); ?>"><?php echo e($contact_email); ?></a></p>
                <?php endif; ?>
                <?php if ($contact_phone !== ''): ?>
                    <p><a href="tel:<?php echo e(preg_replace('/[^0-9\\+]/', '', $contact_phone)); ?>"><?php echo e($contact_phone); ?></a></p>
                <?php endif; ?>
                <p class="muted">Sie moechten Haendler werden? <a href="?page=haendler">Jetzt anfragen</a>.</p>
            </div>
        </div>
    </div>
</section>
