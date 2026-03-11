<div class="header">
    <h1><?= htmlspecialchars($title ?? 'Wartungsbereich', ENT_QUOTES, 'UTF-8') ?></h1>
</div>

<div class="card p-4">
    <h2 style="color: var(--warning);">Diese Funktion befindet sich in Entwicklung</h2>
    <p>Der Bereich <strong><?= htmlspecialchars($title ?? '', ENT_QUOTES, 'UTF-8') ?></strong> wird in Kürze in das neue MVC-Framework migriert.</p> 
    <p>Bitte nutzen Sie vorübergehend noch das alte System oder kontaktieren Sie Ihren Administrator, falls Sie Features aus diesem Bereich dringend benötigen.</p>
</div>
