# Produkte und Bestandskontrolle: Vollständiger Funktionsleitfaden

Das ständige erneute Eintippen derselben Artikelbeschreibungen, Preise und Steuersätze bei jeder Rechnungserstellung ist ineffizient und fehleranfällig. Das Modul **Produkte** fungiert als Ihr zentraler Katalog und Ihr grundlegendes Bestandsverwaltungssystem, das Ihren Rechnungsarbeitsablauf radikal beschleunigen soll.

---

## 1. Erstellen Ihres Hauptkatalogs
Navigieren Sie zur Registerkarte **Produkte**, um mit dem Aufbau Ihrer Datenbank mit Waren und Dienstleistungen zu beginnen.

### Standardartikelkonfiguration
Beim Definieren eines neuen Produkts oder einer neuen Dienstleistung können Sie mehrere dauerhafte Standardeinstellungen konfigurieren:
- **Artikelname und Beschreibung:** Schreiben Sie eine klare, professionelle Beschreibung. Dieser genaue Text wird in den Rechnungsposten eingetragen und stellt so sicher, dass Ihre Kunden stets konsistente Erklärungen zu dem erhalten, was sie kaufen.
- **Standard-Stückpreis:** Legen Sie Ihren Standardpreis fest. Unabhängig davon, ob Sie 150 $/Stunde für die Beratung oder 25 $ für ein physisches Widget berechnen, bedeutet die Einsparung hier, dass Sie nie wieder nach Preisen suchen müssen.
- **Besteuerungsregeln:** Unterschiedliche Artikel haben oft unterschiedliche Steuerpflichten (z. B. können physische Waren einer Umsatzsteuer von 10 % unterliegen, während digitale Dienstleistungen möglicherweise steuerfrei sind). Sie können einem Artikel einen bestimmten *Standardsteuersatz* zuweisen. Wenn Sie diesen Posten zu einer Rechnung hinzufügen, wendet das System automatisch die korrekte Steuerberechnung an, ohne dass Sie einen Finger rühren müssen.

---

## 2. Automatisierte Lager- und Bestandsverwaltung
Wenn Ihr Unternehmen physische Waren und keine abstrakten Dienstleistungen verkauft, ist es wichtig, genau zu verfolgen, wie viele Artikel Sie noch im Lager haben. Die Plattform verfügt über ein automatisiertes Mikroinventursystem.

### Aktivieren der Bestandsverfolgung
Wenn Sie ein physisches Produkt erstellen oder bearbeiten, schalten Sie einfach den Schalter **„Lagerbestand verwalten“** auf die Position EIN.
- Sie werden aufgefordert, Ihre **aktuell verfügbare Menge** einzugeben (z. B. 500 Einheiten).
– Dadurch wird Ihr Basisbestand für diese spezifische SKU festgelegt.

### Automatischer Abzug in Echtzeit
Die Magie des Inventarsystems geschieht während der Abrechnungsphase völlig automatisch.
- Immer wenn Sie eine **Rechnung**, die ein lagergeführtes Produkt enthält, abschließen und senden, liest das System sofort die auf dieser Rechnung in Rechnung gestellte Menge und zieht sie von Ihrer Stammdatenbank ab.
- *Beispiel:* Wenn Sie 500 Widgets haben und einem Kunden eine Rechnung über 50 Widgets senden, sinkt Ihr Stammbestand automatisch auf 450.
- Dadurch wird sichergestellt, dass Sie nie versehentlich einen Artikel überbewerten, den Sie nicht mehr besitzen. 
- *Hinweis:* Bei Schätzungen wird der Lagerbestand nicht abgezogen, da es sich nicht um endgültige Verkäufe handelt. Nur aktive, versendete Rechnungen lösen die Abzugslogik aus.

---

## 3. Schnelle Integration der Rechnungsstellung
Die wahre Leistungsfähigkeit des Produktmoduls wird erst dann deutlich, wenn Sie tatsächlich eine Rechnung oder ein Angebot erstellen.

- Klicken Sie im Invoice Builder auf das Dropdown-Menü **„Produkt hinzufügen“**, anstatt etwas in die leere Zeile einzugeben.
- Wählen Sie Ihren vorkonfigurierten Artikel aus.
- Das System füllt sofort die Beschreibung aus, legt den Stückpreis fest, wendet die korrekte Steuer an und berechnet die Zeilensumme. 
- Das Erstellen einer komplexen Rechnung mit 20 Posten dauert nur wenige Sekunden statt mehrere Minuten manueller Dateneingabe.

---

## 4. Bearbeitung und Kostenanpassungen
Die Preise entwickeln sich im Laufe der Zeit basierend auf den Lieferantenkosten oder der Marktnachfrage.
- Sie können den Standardpreis jedes Artikels in Ihrem Hauptkatalog jederzeit frei bearbeiten.
- **Historische Integrität:** Durch die Änderung des Preises eines Katalogartikels werden alte, bereits gesendete Rechnungen *nicht geändert. Ihre historischen Finanzunterlagen bleiben vollkommen erhalten, während alle neu erstellten Rechnungen die aktualisierte Preislogik übernehmen.