<?php
$settings = $settings ?? [];
$contact_email = $settings['company_email'] ?? 'info@biohome-filter-material.de';
?>
<div class="container" style="padding-top:60px; padding-bottom:60px;">
    <div class="contact-grid">
        <div>
            <h1>Kontakt</h1>
            <p style="margin-bottom:30px;">Schreiben Sie uns eine Nachricht.</p>
            <form onsubmit="alert('Nachricht gesendet!'); return false;">
                <div class="form-group"><label>Name</label><input type="text" class="form-control" required></div>
                <div class="form-group"><label>E-Mail</label><input type="email" class="form-control" required></div>
                <div class="form-group"><label>Nachricht</label><textarea class="form-control" rows="5" required></textarea></div>
                <button class="btn btn-primary">Senden</button>
            </form>
        </div>
        <div>
            <div class="contact-info-card" style="margin-bottom: 2rem;">
                <h3 style="color:white; border-bottom:1px solid #334155; padding-bottom:15px;">Daten</h3>
                <div class="contact-item"><i class="ph ph-envelope"></i><div><?php echo htmlspecialchars($contact_email); ?></div></div>
            </div>
            
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem;">
                <h3 style="color: #0f172a; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 15px;">Sind Sie Geschäftskunde?</h3>
                <p style="color: #475569; font-size: 0.95rem; margin-bottom: 1.5rem;">Entdecken Sie die Vorteile von Biohome für Industrie, Aquakultur und Fachhandel.</p>
                <a href="/b2b" class="btn btn-primary" style="display: block; width: 100%; text-align: center; margin-bottom: 10px; background: #3b82f6; border-color: #3b82f6;">Jetzt Händler werden</a>
                <a href="/b2b" class="btn btn-outline" style="display: block; width: 100%; text-align: center;">B2B Beratung anfordern</a>
            </div>
        </div>
    </div>
</div>
