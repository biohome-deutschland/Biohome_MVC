<div class="header">
    <h1>Admin Dashboard</h1>
    <a href="/" target="_blank" class="btn btn-primary">Zur Webseite &rarr;</a>
</div>

<div style="margin-bottom: 20px;">
    <p>Willkommen im Administrationsbereich.</p>
</div>

<!-- DASHBOARD GRID (Schnellzugriff als Karten) -->
<div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
    
    <!-- Karte: Produkte -->
    <div class="card">
        <div class="card-body">
            <h3 style="margin-top:0; color:var(--primary);">Produktkatalog</h3>
            <p style="color:#64748b; font-size:0.9rem;">Biohome Produkte, Bilder und Texte bearbeiten.</p>
            <a href="/admin/products" class="btn btn-sm btn-primary">Produkte verwalten</a>
        </div>
    </div>

    <!-- Karte: Filterkatalog -->
    <div class="card">
        <div class="card-body">
            <h3 style="margin-top:0; color:var(--primary);">Filterkatalog</h3>
            <p style="color:#64748b; font-size:0.9rem;">Filterarten, Hersteller und Filter verwalten.</p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="/admin/filters" class="btn btn-sm btn-primary">Filter</a>
                <a href="/admin/filter-calculator" class="btn btn-sm" style="background:#dcfce7; color:#166534;">Kalkulator</a>
                <a href="/admin/filter-types" class="btn btn-sm" style="background:#e2e8f0; color:#334155;">Filterarten</a>
                <a href="/admin/filter-brands" class="btn btn-sm" style="background:#e2e8f0; color:#334155;">Hersteller</a>
            </div>
        </div>
    </div>

    <!-- Karte: Seiten -->
    <div class="card">
        <div class="card-body">
            <h3 style="margin-top:0;">Seiten & Inhalte</h3>
            <p style="color:#64748b; font-size:0.9rem;">Texte der allgemeinen Unterseiten bearbeiten.</p>
            <a href="/admin/pages" class="btn btn-sm" style="background:#e2e8f0; color:#334155;">Seiten öffnen</a>
        </div>
    </div>

    <!-- Karte: Medien -->
    <div class="card">
        <div class="card-body">
            <h3 style="margin-top:0;">Mediathek</h3>
            <p style="color:#64748b; font-size:0.9rem;">Bilder und Dokumente verwalten.</p>
            <a href="/admin/media" class="btn btn-sm" style="background:#e2e8f0; color:#334155;">Medien öffnen</a>
        </div>
    </div>

     <!-- Karte: Einstellungen -->
     <div class="card">
        <div class="card-body">
            <h3 style="margin-top:0;">System</h3>
            <p style="color:#64748b; font-size:0.9rem;">Globale Einstellungen und Themes.</p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="/admin/settings" style="font-size:0.85rem; text-decoration:underline;">Settings</a>
                <a href="/admin/theme-import" style="font-size:0.85rem; text-decoration:underline;">Import</a>
                <a href="/admin/export" style="font-size:0.85rem; text-decoration:underline;">Export</a>
            </div>
        </div>
    </div>

</div>
