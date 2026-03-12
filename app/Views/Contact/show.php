<?php
$settings = $settings ?? [];
$contact_email = $settings['company_email'] ?? 'info@biohome-filter-material.de';
$success = $success ?? false;
$error = $error ?? [];
$old_values = $old_values ?? [];
$csrf_token = $csrf_token ?? '';
?>
<div class="container" style="padding-top:60px; padding-bottom:60px;">
    <div class="contact-grid">
        <div>
            <h1>Kontakt</h1>
            <p style="margin-bottom:30px;">Schreiben Sie uns eine Nachricht.</p>

            <?php if ($success): ?>
                <div class="form-message form-message--success" role="alert">
                    Ihre Nachricht wurde erfolgreich gesendet! Wir werden uns schnellstmöglich bei Ihnen melden.
                </div>
            <?php endif; ?>

            <?php if (isset($error['general'])): ?>
                <div class="form-message form-message--error" role="alert">
                    <?php echo htmlspecialchars($error['general']); ?>
                </div>
            <?php endif; ?>

            <form action="/kontakt/senden" method="POST" class="form-grid">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                
                <!-- Honeypot -->
                <input type="text" name="website" tabindex="-1" class="honeypot" autocomplete="off" aria-hidden="true" style="display:none">

                <div class="form-field">
                    <label for="contact-name">Name *</label>
                    <input type="text" id="contact-name" name="name" class="form-control" required aria-required="true"
                           value="<?php echo htmlspecialchars($old_values['name'] ?? ''); ?>"
                           aria-invalid="<?php echo isset($error['name']) ? 'true' : 'false'; ?>"
                           <?php echo isset($error['name']) ? 'aria-describedby="error-name"' : ''; ?>>
                    <?php if (isset($error['name'])): ?>
                        <div id="error-name" class="form-message form-message--error" style="padding: 6px 12px; margin-top: 4px; margin-bottom: 0;">
                            <?php echo htmlspecialchars($error['name']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="contact-email">E-Mail *</label>
                    <input type="email" id="contact-email" name="email" class="form-control" required aria-required="true"
                           value="<?php echo htmlspecialchars($old_values['email'] ?? ''); ?>"
                           aria-invalid="<?php echo isset($error['email']) ? 'true' : 'false'; ?>"
                           <?php echo isset($error['email']) ? 'aria-describedby="error-email"' : ''; ?>>
                    <?php if (isset($error['email'])): ?>
                        <div id="error-email" class="form-message form-message--error" style="padding: 6px 12px; margin-top: 4px; margin-bottom: 0;">
                            <?php echo htmlspecialchars($error['email']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="contact-phone">Telefon (optional)</label>
                    <input type="tel" id="contact-phone" name="phone" class="form-control"
                           value="<?php echo htmlspecialchars($old_values['phone'] ?? ''); ?>">
                </div>

                <div class="form-field">
                    <label for="contact-subject">Betreff</label>
                    <input type="text" id="contact-subject" name="subject" class="form-control"
                           value="<?php echo htmlspecialchars($old_values['subject'] ?? ''); ?>">
                </div>

                <div class="form-field">
                    <label for="contact-message">Nachricht *</label>
                    <textarea id="contact-message" name="message" class="form-control" rows="5" required aria-required="true"
                              aria-invalid="<?php echo isset($error['message']) ? 'true' : 'false'; ?>"
                              <?php echo isset($error['message']) ? 'aria-describedby="error-message"' : ''; ?>><?php echo htmlspecialchars($old_values['message'] ?? ''); ?></textarea>
                    <?php if (isset($error['message'])): ?>
                        <div id="error-message" class="form-message form-message--error" style="padding: 6px 12px; margin-top: 4px; margin-bottom: 0;">
                            <?php echo htmlspecialchars($error['message']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Nachricht Senden</button>
                </div>
            </form>
        </div>
        
        <div class="contact-info-card" style="align-self: start; background: var(--brand-dark); border-radius: 12px; padding: 24px; color: white;">
            <h3 style="color:white; border-bottom:1px solid rgba(255,255,255,0.2); padding-bottom:15px; margin-top: 0;">Kontaktdaten</h3>
            <div class="contact-item" style="display: flex; gap: 12px; align-items: center; margin-top: 20px;">
                <i class="ph ph-envelope" style="font-size: 1.5rem;"></i>
                <div>
                    <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>" style="color: white; text-decoration: underline;">
                        <?php echo htmlspecialchars($contact_email); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
