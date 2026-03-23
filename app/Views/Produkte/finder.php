<?php
// app/Views/Produkte/finder.php
$page = $page ?? ['title' => 'Produkt-Finder'];
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Berater</p>
        <h1 class="page-title"><?php echo htmlspecialchars($page['title']); ?></h1>
        <p class="page-subtitle">Beantworten Sie 2 kurze Fragen, und wir zeigen Ihnen welches Biohome-Medium für Ihre Anwendung geeignet ist und verweisen Sie auf die detaillierte Bestückungsempfehlung im Filterkatalog.</p>
    </div>
</section>

<section class="section" style="padding-bottom: 5rem;">
    <div class="container" style="max-width: 800px;">
        <div id="finderWizard" style="background: #fff; padding: 3rem; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
            
            <!-- Step 1: Wasserart -->
            <div class="wizard-step" id="step1">
                <p style="font-size: 0.9rem; color: #94a3b8; margin-bottom: 0.5rem;">Schritt 1 von 2</p>
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #0f172a;">Welche Art von Aquarium oder Teich betreiben Sie?</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <button class="btn btn-outline wizard-option" data-step="1" data-value="suesswasser" style="height: auto; padding: 2rem 1rem; flex-direction: column; gap: 0.75rem; text-align: center;">
                        <i class="ph ph-fish-simple" style="font-size: 2.5rem; color: #3b82f6;"></i>
                        <span style="font-weight: 600;">Süßwasser</span>
                        <span style="font-size: 0.85rem; color: #64748b;">Aquarium</span>
                    </button>
                    <button class="btn btn-outline wizard-option" data-step="1" data-value="meerwasser" style="height: auto; padding: 2rem 1rem; flex-direction: column; gap: 0.75rem; text-align: center;">
                        <i class="ph ph-drop" style="font-size: 2.5rem; color: #0ea5e9;"></i>
                        <span style="font-weight: 600;">Meerwasser</span>
                        <span style="font-size: 0.85rem; color: #64748b;">Riff &amp; Meeresaquarium</span>
                    </button>
                    <button class="btn btn-outline wizard-option" data-step="1" data-value="teich" style="height: auto; padding: 2rem 1rem; flex-direction: column; gap: 0.75rem; text-align: center;">
                        <i class="ph ph-waves" style="font-size: 2.5rem; color: #16a34a;"></i>
                        <span style="font-weight: 600;">Teich</span>
                        <span style="font-size: 0.85rem; color: #64748b;">Koi &amp; Gartenteich</span>
                    </button>
                </div>
            </div>

            <!-- Step 2: Filtertyp -->
            <div class="wizard-step" id="step2" style="display: none;">
                <p style="font-size: 0.9rem; color: #94a3b8; margin-bottom: 0.5rem;">Schritt 2 von 2</p>
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #0f172a;">Welchen Filtertyp verwenden Sie?</h2>
                <div id="filterOptionsContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <!-- Options populated via JS -->
                </div>
                <div style="margin-top: 2rem;">
                    <button class="btn btn-ghost wizard-back" data-target="step1" style="font-size: 0.9rem;"><i class="ph ph-arrow-left"></i> Zurück</button>
                </div>
            </div>

            <!-- Step 3: Result -->
            <div class="wizard-step" id="step3" style="display: none; text-align: center;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #16a34a; margin-bottom: 1.5rem;">
                    <i class="ph ph-check-circle" style="font-size: 3rem;"></i>
                </div>
                <h2 style="font-size: 2rem; margin-bottom: 0.5rem; color: #0f172a;">Empfehlung für Sie</h2>
                <p style="color: #475569; font-size: 1.1rem; margin-bottom: 2rem;">Basierend auf Ihren Angaben empfehlen wir:</p>
                
                <div id="resultBox" style="background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 12px; padding: 2rem; margin-bottom: 1.5rem; text-align: left;">
                    <h3 id="resultTitle" style="color: var(--brand, #16a34a); font-size: 1.8rem; margin-bottom: 0.5rem;"></h3>
                    <p id="resultText" style="color: #475569; margin-bottom: 0;"></p>
                </div>

                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; text-align: left;">
                    <p style="margin: 0; color: #92400e; font-size: 0.95rem;"><i class="ph ph-info" style="margin-right: 0.5rem;"></i><strong>Präzise Mengenempfehlung:</strong> Im Filterkatalog finden Sie für jeden Filtertyp exakte Tabellen, wie viel Liter Biohome-Medium in Ihren Filter passen.</p>
                </div>
                
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
                    <a id="resultCatalogLink" href="/produkte" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;"><i class="ph ph-package" style="margin-right: 0.5rem;"></i>Produkt im Katalog</a>
                    <a id="resultFilterLink" href="/filtertypen" class="btn btn-outline" style="padding: 1rem 2rem; font-size: 1.1rem;"><i class="ph ph-funnel" style="margin-right: 0.5rem;"></i>Filterbefüllung nachschlagen</a>
                </div>
                <div style="margin-top: 1.5rem;">
                    <button class="btn btn-ghost wizard-back" data-target="step1" style="font-size: 0.9rem;"><i class="ph ph-arrow-counterclockwise" style="margin-right: 0.25rem;"></i> Neu starten</button>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let selections = { wasser: '', filter: '' };

    // Filter type options per water type
    const filterOptions = {
        'suesswasser': [
            { id: 'innenfilter',  label: 'Innenfilter / HOB', icon: 'ph-box-arrow-down', hint: 'z.B. Eheim Aquaball, Fluval U-Serie' },
            { id: 'aussenfilter', label: 'Außenfilter', icon: 'ph-cylinder', hint: 'z.B. Eheim Professionel, Fluval FX, JBL CristalProfi' },
            { id: 'sumpf',        label: 'Filterbecken / Sumpf', icon: 'ph-square-split-horizontal', hint: 'Offenes Technikbecken unter dem Aquarium' }
        ],
        'meerwasser': [
            { id: 'aussenfilter-meer', label: 'Außenfilter', icon: 'ph-cylinder', hint: 'z.B. Eheim, Fluval FX' },
            { id: 'sumpf-meer',        label: 'Filterbecken / Rieselfilter', icon: 'ph-square-split-horizontal', hint: 'Sumpf mit Rieselfilterturm (Bakki)' }
        ],
        'teich': [
            { id: 'druckfilter',  label: 'Druckfilter / Trommelfilter', icon: 'ph-cylinder', hint: 'z.B. Oase Biosmart, Pontec' },
            { id: 'mehrkammer',   label: 'Mehrkammerfilter', icon: 'ph-squares-four', hint: 'Mehrkammer-Schwerkraftfilter / Klärfix' },
            { id: 'rieselfilter', label: 'Rieselfilter (Bakki Shower)', icon: 'ph-cloud-rain', hint: 'Turm-Rieselfilter für Koi-Teiche' }
        ]
    };

    // Recommendations using only real Biohome products
    const recommendations = {
        // Süßwasser
        'innenfilter': {
            title: 'Biohome Mini Ultra',
            text: 'Die kompakten Pellets des Biohome Mini Ultra passen optimal in die engen Filterkammern von Innenfiltern und HOB-Filtern. Durch die Sinterstruktur entsteht trotz geringen Volumens eine hohe biologisch aktive Fläche.',
            catalogLink: '/produkte',
            filterLink: '/filtertypen'
        },
        'aussenfilter': {
            title: 'Biohome Ultimate oder Biohome Plus',
            text: 'Biohome Ultimate ist der Allrounder für Außenfilter mit der vollen Spurenelement-Ausrüstung zur Förderung anaerober Bakterien. Biohome Plus ist der solide Einstieg. Die Filterkatalogliste zeigt Ihnen genau, wie viel Liter je nach Filtermodell empfohlen werden.',
            catalogLink: '/produkte?category=suesswasser',
            filterLink: '/filtertypen'
        },
        'sumpf': {
            title: 'Biohome Maxi Ultimate',
            text: 'Im offenen Filterbecken (Sumpf) kann das große Maxi Ultimate sein volles Potential entfalten: maximale Durchströmung und exzellente anaerobe Zonen für Denitrifikation bei hohem Bestand.',
            catalogLink: '/produkte',
            filterLink: '/filtertypen'
        },
        // Meerwasser
        'aussenfilter-meer': {
            title: 'Biohome Ultimate Marine',
            text: 'Das Biohome Ultimate Marine ist speziell für den Einsatz im Salzwasser entwickelt und hat die NTUA-Studie unter extremen Bedingungen bestanden. Für Außenfilter empfehlen sich die Standard-Pellets.',
            catalogLink: '/produkte?category=meerwasser',
            filterLink: '/filtertypen'
        },
        'sumpf-meer': {
            title: 'Biohome Maxi Ultimate Marine',
            text: 'Für Rieselfiltertürme (Bakki Showers) im Meerwasserbereich ist das große Biohome Maxi Ultimate Marine ideal: starke Wasserbelüftung und maximale Denitrifikation für Riff-Aquarien.',
            catalogLink: '/produkte?category=meerwasser',
            filterLink: '/filtertypen'
        },
        // Teich
        'druckfilter': {
            title: 'Biohome Standard oder Biohome Ultimate',
            text: 'Im Druckfilter sorgen die robusten Biohome-Pellets für hervorragende Nitrifikation und fördern Denitrifikation. Die Standardgröße passt in nahezu jeden Durchströmungsfilter. Nutzen Sie unseren Kalkulator für die genaue Menge.',
            catalogLink: '/produkte?category=teich',
            filterLink: '/filter-calculator'
        },
        'mehrkammer': {
            title: 'Biohome Maxi Ultimate',
            text: 'In Mehrkammerfiltern (z.B. Nexus, Filtreau, Selbstbau) eignet sich das große Maxi-Format besonders, da es kaum verstopft und eine gleichmäßige Durchströmung über alle Kammern hinweg sicherstellt.',
            catalogLink: '/produkte?category=teich',
            filterLink: '/filter-calculator'
        },
        'rieselfilter': {
            title: 'Biohome Showermedia oder Biohome Maxi',
            text: 'Das Biohome Showermedia wurde speziell für Rieselfilteranwendungen (Bakki Showers, Bioturm) entwickelt. Es bietet maximale Oberfläche bei optimaler Belüftung. Alternativ funktioniert das Biohome Maxi Ultimate hervorragend.',
            catalogLink: '/produkte?category=teich',
            filterLink: '/filter-calculator'
        }
    };

    const container = document.getElementById('filterOptionsContainer');

    // Step 1 click
    document.querySelectorAll('.wizard-option[data-step="1"]').forEach(btn => {
        btn.addEventListener('click', function() {
            selections.wasser = this.dataset.value;
            container.innerHTML = '';
            filterOptions[selections.wasser].forEach(opt => {
                const b = document.createElement('button');
                b.className = 'btn btn-outline';
                b.style.cssText = 'height: auto; padding: 1.5rem 1rem; flex-direction: column; gap: 0.5rem; text-align: center;';
                b.innerHTML = `
                    <i class="ph ${opt.icon}" style="font-size: 2rem; color: #64748b;"></i>
                    <span style="font-weight: 600;">${opt.label}</span>
                    <span style="font-size: 0.8rem; color: #94a3b8;">${opt.hint}</span>`;
                b.addEventListener('click', () => {
                    selections.filter = opt.id;
                    showResult();
                });
                container.appendChild(b);
            });
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        });
    });

    // Back buttons
    document.querySelectorAll('.wizard-back').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.dataset.target;
            document.querySelectorAll('.wizard-step').forEach(s => s.style.display = 'none');
            document.getElementById(target).style.display = 'block';
            if (target === 'step1') { selections = { wasser: '', filter: '' }; }
        });
    });

    function showResult() {
        const rec = recommendations[selections.filter];
        if (rec) {
            document.getElementById('resultTitle').textContent = rec.title;
            document.getElementById('resultText').textContent  = rec.text;
            document.getElementById('resultCatalogLink').href  = rec.catalogLink;
            document.getElementById('resultFilterLink').href   = rec.filterLink;
            // Update filter link label based on type
            const isTeich = selections.wasser === 'teich';
            document.getElementById('resultFilterLink').innerHTML =
                isTeich
                    ? '<i class="ph ph-calculator" style="margin-right: 0.5rem;"></i>Zum Teich-Kalkulator'
                    : '<i class="ph ph-funnel" style="margin-right: 0.5rem;"></i>Filterbefüllung nachschlagen';
        }
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'block';
    }
});
</script>
