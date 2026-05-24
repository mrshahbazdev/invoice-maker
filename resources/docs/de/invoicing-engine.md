# Die Rechnungsstellungsmaschine: Ein vollständiger Leitfaden

Die Kernlogik dieser Plattform dreht sich um eine hochentwickelte, automatisierte Rechnungsstellungs-Engine, die Ihnen dabei hilft, professionelle Rechnungen völlig nahtlos zu erstellen. Dieser Leitfaden deckt den gesamten Funktionsumfang ab, der im Rechnungserstellungsablauf verfügbar ist.

---

## 1. Eine neue Rechnung veranlassen
Das Erstellen einer Rechnung ist unkompliziert. Navigieren Sie zu Ihrem Modul **Rechnungen** und klicken Sie auf **Neue Rechnung erstellen**. 
Dadurch wird der interaktive Drag-and-Drop-Dokumentersteller gestartet.

### Rechnungsmetadaten
Bevor Sie Werbebuchungen hinzufügen, richten Sie die Kernmetadaten ein, die das Dokument definieren:
- **Rechnungsnummer:** Standardmäßig erhöht das System Ihre Rechnungsnummern automatisch (z. B. INV-0001 wird zu INV-0002). Sie können jedoch das Präfix und das Nummerierungsschema in Ihren globalen Einstellungen manuell überschreiben, wenn Sie ein benutzerdefiniertes Format verwenden.
- **Ausstellungsdatum:** Das Datum, an dem das Dokument offiziell erstellt wurde. Der Standardwert ist heute.
- **Fälligkeitsdatum/Zahlungsbedingungen:** Legen Sie fest, wann Sie voraussichtlich das Geld erhalten. Sie können genaue Daten auswählen oder dynamische Begriffe wie „Netto 15“, „Netto 30“ oder „Fällig bei Erhalt“ verwenden. Das System berechnet anhand des Ausstellungsdatums automatisch das genaue Fälligkeitsdatum.
- **Kundenauswahl:** Wählen Sie einen vorhandenen Kunden aus Ihrem CRM aus oder definieren Sie schnell einen neuen inline, ohne den Builder zu verlassen.

---

## 2. Einzelposten verwalten
Im Abschnitt „Einzelposten“ erstellen Sie die eigentliche Rechnung. 

### Produkte und Dienstleistungen hinzufügen
Sie können Werbebuchungen auf zwei verschiedene Arten hinzufügen:
1. **Manuelle Eingabe:** Geben Sie vollständig benutzerdefinierte Beschreibungen, beliebige Preise und bestimmte Mengen direkt in eine leere Zeile ein. Dies ist perfekt für individuelle Projektarbeiten oder einzigartige Servicegebühren.
2. **Aus dem Lagerbestand:** Klicken Sie auf das Dropdown-Menü „Produkt hinzufügen“, um vorab gespeicherte Artikel aus Ihrem Produkt-/Dienstleistungskatalog auszuwählen. Das System fügt sofort die vordefinierte Beschreibung, den Stückpreis und die Standardsteuersätze für diesen Artikel ein, wodurch Sie enorme Zeit sparen.

### Mathematik und Steuern in Echtzeit
Die gesamte Tabelle ist mathematisch integriert.
- Wenn Sie Mengen oder Stückpreise anpassen, werden die Zeilensummen sofort aktualisiert.
- **Positionssteuern:** Sie können einer einzelnen Position mehrere Steuersätze (z. B. eine regionale Mehrwertsteuer und eine sekundäre Umsatzsteuer) zuweisen. Das System berechnet diese Steuern dynamisch und individuell für jede Zeile.
- **Neuordnung per Drag-and-Drop:** Fassen Sie den Griff auf der linken Seite einer beliebigen Zeile an, um die Reihenfolge der Elemente in der endgültigen PDF-Datei neu anzuordnen. Die Mathematik rechnet weiterhin perfekt, unabhängig von der Reihenfolge.

---

## 3. Rabatte und globale Modifikatoren
Manchmal müssen Sie die Gesamtsumme über die einzelnen Werbebuchungen hinaus anpassen.

- **Globale Rabatte:** Unten im Rechnungsersteller können Sie einen globalen Rabatt gewähren. Sie können wählen, ob dieser Rabatt ein buchstäblicher Festbetrag (z. B. „50 $ Rabatt“) oder ein Prozentsatz der Zwischensumme (z. B. „10 % Rabatt“) ist. Die Gesamtsumme wird dynamisch aktualisiert, um die Einsparungen widerzuspiegeln.
- **Hinweise und Bedingungen:** Fügen Sie dem Kunden eine personalisierte Nachricht hinzu (z. B. „Vielen Dank für Ihr Geschäft!“) und definieren Sie strenge rechtliche Geschäftsbedingungen (z. B. „Bei verspäteter Zahlung wird eine Strafe von 5 % erhoben“).

---

## 4. Versand und Lieferung
Sobald Ihre Rechnung fertiggestellt ist, ist es Zeit, bezahlt zu werden.

### Automatisierter E-Mail-Versand
Durch Klicken auf „Rechnung senden“ wird der E-Mail-Launcher geöffnet.
- Das System lädt automatisch die Ihrem Kunden zugewiesene primäre E-Mail-Adresse.
- Sie können die Betreffzeile und den HTML-Text der E-Mail stark anpassen. Wenn Sie im CRM eine bestimmte Vorlage für diesen Kunden definiert haben, wird diese vorinstalliert.
- Die Plattform hängt ein hochkomprimiertes, schön generiertes PDF des Dokuments direkt an die ausgehende E-Mail an.

### Kundenportal „Magic Link“
Entscheidend ist, dass die E-Mail auch einen „Magic Link“ enthält. Wenn Ihr Kunde auf diesen Link klickt, wird er direkt zu seinem sicheren, passwortlosen Kundenportal weitergeleitet, wo er die Rechnung dynamisch einsehen kann.

### Statusverfolgung
Sobald eine Rechnung gesendet wurde, beginnt das System automatisch mit der Verfolgung ihres Status:
- Sie sehen genau, wann der Kunde die E-Mail öffnet und das Dokument online ansieht (der Status ändert sich von „Gesendet“ zu „Gesehen“).
- Wenn das Fälligkeitsdatum überschritten wird, markiert das System die Rechnung mit einem leuchtend roten Abzeichen **Überfällig**.
- Wenn Zahlungen protokolliert werden (entweder manuell oder über Stripe), wird der Kontostand aktualisiert. Bei teilweiser Zahlung wird auf „Teilweise“ umgestellt. Wenn der Betrag vollständig abgerechnet ist, wird er als „Bezahlt“ archiviert.