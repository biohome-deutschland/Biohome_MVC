<?php
require_once __DIR__ . '/../public/index.php';

$db = \Core\Model::getDB();

$faq_html = '
<div class="faq-category">
    <h2 class="category-title">Aquaristik: Grundlagen & Anwendung</h2>
    <div class="faq-list">
        <div class="faq-item">
            <div class="faq-question">Was ist Biohome und woraus besteht es genau?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Biohome ist ein Hochleistungs-Filtermedium aus gesintertem Glas (hochwertiger Quarzsand). Es wird thermisch behandelt, um eine extrem harte, aber vollständig offenporige Struktur zu erzeugen. Anders als Keramik (Ton) bietet es durch seine mikroskopischen Tunnelstrukturen Lebensraum für aerobe (außen) UND anaerobe (innen) Bakterien.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Wie funktioniert der Nitratabbau (Denitrifikation)?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Das Wasser fließt durch die langen Poren ins Innere. Dabei verbrauchen die äußeren Bakterien den Sauerstoff für den Abbau von Ammonium/Nitrit. Im Kern entstehen so sauerstoffarme (anaerobe) Zonen. Hier siedeln Bakterien, die Nitrat (NO3) aufspalten, um an Sauerstoff zu gelangen. Als "Abfallprodukt" entsteht harmloses Stickstoffgas.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Wie viel Biohome brauche ich (Dosierung)?</div>
            <div class="faq-answer"><div class="faq-answer-inner">
                <p><strong>Gesellschaftsbecken:</strong> ca. 1 kg pro 100 Liter.</p>
                <p><strong>Starker Besatz (Goldfisch, Malawi):</strong> 1,5 kg - 2,0 kg pro 100 Liter.</p>
                <p><strong>Meerwasser:</strong> ca. 1,5 kg - 2,0 kg pro 100 Liter.</p>
                <p>Kleine Mengen reichen für Ammonium/Nitrit, aber für die effektive Nitratreduktion benötigen Sie das entsprechende Volumen.</p>
            </div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Wie lange dauert die Einlaufphase?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ammonium und Nitrit werden oft schon nach 2-3 Wochen abgebaut. Die anaeroben Bakterien im Kern wachsen jedoch sehr langsam. Rechnen Sie mit 4 bis 6 Monaten, bis der Nitratfilter seine volle Leistung erreicht.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Muss ich das Medium austauschen?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Nein. Biohome ist extrem langlebig. Ein Austausch ist nicht nötig, solange es nicht physisch zerstört wird. Es sollte lediglich bei der Filterreinigung vorsichtig in Aquarienwasser gespült werden.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Unterschied Standard vs. Plus vs. Ultimate?</div>
            <div class="faq-answer"><div class="faq-answer-inner">
                <p><strong>Standard:</strong> Reines Sinterglas.</p>
                <p><strong>Plus:</strong> Angereichert mit Spurenelementen (Eisenerz) für besseres Bakterienwachstum.</p>
                <p><strong>Ultimate:</strong> Höchste Porosität und zusätzliche Spurenelemente für maximale Leistung.</p>
            </div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Hilft Biohome gegen Algen?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Indirekt ja. Durch den effizienten Abbau von Nitrat und Phosphat (durch gesunde Bakterienkulturen) wird den Algen die Nahrungsgrundlage entzogen.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Kann ich verschiedene Sorten mischen?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ja, das ist problemlos möglich. Viele Kunden nutzen z.B. Standard als Basis und Ultimate als "Turbo".</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Beeinflusst es pH-Wert oder Härte?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Nein, Biohome ist wasserneutral und beeinflusst die Wasserwerte nicht chemisch.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Was ist Biogravel?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Eine kleinere Version von Biohome, ideal für Innenfilter, Garnelenbecken oder als oberste Schicht im Bodengrund.</div></div>
        </div>
    </div>
</div>

<div class="faq-category">
    <h2 class="category-title">Meerwasser Aquaristik</h2>
    <div class="faq-list">
        <div class="faq-item">
            <div class="faq-question">Warum gibt es eine "Marine"-Version?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Die Marine-Version ist speziell auf die Bedürfnisse von Meerwasserbakterien abgestimmt und enthält zusätzliche Spurenelemente, die im Riffaquarium vorteilhaft sind.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Kann Biohome Lebendgestein ersetzen?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ja, Biohome kann einen großen Teil der biologischen Filterleistung von Lebendgestein übernehmen. 1 kg Biohome Ultimate Marine bietet ca. so viel aktive Oberfläche wie 10-15 kg Lebendgestein. Dies ist besonders bei "Dead Rock" oder Keramik-Aufbauten wichtig.</div></div>
        </div>
    </div>
</div>

<div class="faq-category">
    <h2 class="category-title">Teich & Koi</h2>
    <div class="faq-list">
        <div class="faq-item">
            <div class="faq-question">Welches Biohome für Koi-Teiche?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Für Teiche empfehlen wir Biohome Ultimate (groß) oder spezielles Showermedia für Rieselfilter.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Dosierung für Teiche?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Als Faustformel gilt: 1 kg Biohome pro 1.000 Liter Teichwasser (bei normalem Besatz). Bei starkem Koi-Besatz entsprechend mehr.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Ist Showermedia eckig oder rund?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Showermedia hat eine unregelmäßige, eher kugelige Form, um eine optimale Durchströmung im Rieselfilter zu gewährleisten.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Winterbetrieb: Darf es einfrieren?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Der Filter sollte im Winter idealerweise durchlaufen (ggf. gedrosselt). Wenn das Medium komplett einfriert, sterben die Bakterien ab, aber das Material selbst nimmt keinen Schaden.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Verstopfung bei Algenblüte?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Durch die grobe Struktur verstopft Biohome deutlich weniger als feine Schwämme. Eine gute mechanische Vorfilterung ist dennoch ratsam.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Kombination mit Japanmatten?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Eine hervorragende Kombination! Japanmatten für die mechanische/grobe biologische Reinigung, Biohome für den intensiven Schadstoffabbau.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Saisonstart im Frühjahr?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Wir empfehlen die Verwendung von Filterstarter-Bakterien, um die Biologie nach der Winterpause schnell wieder zu aktivieren.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">löst es sich auf?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Nein, Biohome ist extrem stabil und behält seine Struktur über viele Jahre.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Einsatz in Druckfiltern?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ja, Biohome kann auch in Druckfiltern eingesetzt werden, profitiert aber von sauerstoffreichen Umgebungen.</div></div>
        </div>
    </div>
</div>

<div class="faq-category">
    <h2 class="category-title">Profi & Zucht</h2>
    <div class="faq-list">
        <div class="faq-item">
            <div class="faq-question">Bare-Bottom Tanks (Zucht)?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ideal. Biohome Bricks im Becken ersetzen den fehlenden Bodengrund als biologischen Filter.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Betrieb bei niedrigem pH (< 6)?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ja, das Material ist säurestabil und löst sich nicht auf. Beachten Sie jedoch, dass die Filterleistung bei sehr niedrigem pH sinkt.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Vergleich zu Moving Bed (K1)?</div>
            <div class="faq-answer"><div class="faq-answer-inner">K1 ist top für Nitrifikation, kann aber bauartbedingt kaum Nitrat abbauen. Biohome schließt den Kreislauf durch anaerobe Zonen.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Stapelbarkeit im Rieselfilter?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ja, durch die Form bleibt die Schüttung locker genug für optimalen Gasaustausch und verhindert Staunässe.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Absorbiert es Medikamente?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Nein, Biohome absorbiert keine Medikamente. Antibiotika können jedoch die Bakterien schädigen -> Neuanimpfung nötig.</div></div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Gibt es Großgebinde?</div>
            <div class="faq-answer"><div class="faq-answer-inner">Ja, 10kg und 20kg Säcke für Zuchtanlagen und große Teiche sind verfügbar.</div></div>
        </div>
    </div>
</div>
';

try {
    // Update cms_pages
    $stmt = $db->prepare('UPDATE cms_pages SET content = :content WHERE slug = :slug');
    $stmt->execute(['content' => $faq_html, 'slug' => 'faq']);
    echo "cms_pages affected: " . $stmt->rowCount() . "\n";
    
    // Update pages
    $stmt = $db->prepare('UPDATE pages SET content = :content WHERE slug = :slug');
    $stmt->execute(['content' => $faq_html, 'slug' => 'faq']);
    echo "pages affected: " . $stmt->rowCount() . "\n";
    
    // Final check
    $stmt = $db->prepare('SELECT content FROM cms_pages WHERE slug = "faq"');
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && strpos($row['content'], "Aquaristik: Grundlagen") !== false) {
        echo "VERIFIED: content in cms_pages matches.\n";
    } else {
        echo "FAILED: content in cms_pages does not match.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
