# Controllo prodotti e inventario: guida completa alle funzionalità

Ridigitare costantemente le stesse descrizioni di articoli, prezzi e aliquote fiscali ogni volta che si genera una fattura è inefficiente e soggetto a errori. Il modulo **Prodotti** funge da catalogo centrale e sistema di gestione dell'inventario di base, progettato per accelerare radicalmente il flusso di lavoro di fatturazione.

---

## 1. Creazione del catalogo principale
Passa alla scheda **Prodotti** per iniziare a creare il tuo database di beni e servizi.

### Configurazione articolo standard
Quando definisci un nuovo prodotto o servizio, puoi configurare diverse impostazioni predefinite permanenti:
- **Nome e descrizione dell'articolo:** Scrivi una descrizione chiara e professionale. Questo testo esatto verrà popolato nella voce della fattura, garantendo che i tuoi clienti ricevano sempre spiegazioni coerenti su ciò che stanno acquistando.
- **Prezzo unitario predefinito:** imposta la tariffa standard. Sia che tu addebiti $ 150 l'ora per una consulenza o $ 25 per un widget fisico, salvarlo qui significa che non dovrai mai più cercare i prezzi.
- **Norme fiscali:** Articoli diversi hanno spesso passività fiscali diverse (ad esempio, i beni fisici potrebbero avere un'imposta sulle vendite del 10%, mentre i servizi digitali potrebbero essere esenti da imposte). È possibile assegnare una specifica *Aliquota fiscale predefinita* a un articolo. Quando aggiungi questo articolo a una fattura, il sistema applica automaticamente i calcoli fiscali corretti senza che tu muova un dito.

---

## 2. Gestione automatizzata delle scorte e dell'inventario
Se la tua azienda vende beni fisici anziché servizi astratti, è fondamentale monitorare esattamente quanti articoli hai lasciato nel magazzino. La piattaforma dispone di un sistema di micro-inventario automatizzato.

### Abilitazione del monitoraggio delle scorte
Quando crei o modifichi un prodotto fisico, sposta semplicemente l'interruttore **"Gestisci stock"** sulla posizione ON.
- Ti verrà richiesto di inserire la tua **Quantità attuale disponibile** (ad esempio, 500 unità).
- Ciò stabilisce il tuo inventario di base per questo SKU specifico.

### Detrazione automatica in tempo reale
La magia del sistema di inventario avviene durante la fase di fatturazione in modo completamente automatico.
- Ogni volta che finalizzi e invii una **Fattura** che contiene un prodotto gestito in stock, il sistema legge immediatamente la quantità fatturata su quella fattura e la detrae dal tuo database principale.
- *Esempio:* Se hai 500 widget e invii una fattura fatturando a un cliente 50 widget, il tuo stock principale scende automaticamente a 450.
- Ciò ti garantisce di non vendere mai accidentalmente un oggetto che non possiedi più. 
- *Nota:* Le stime non detraggono le scorte, poiché non sono vendite finalizzate. Solo le fatture attive e inviate attivano la logica di detrazione.

---

## 3. Integrazione rapida della fatturazione
La vera potenza del modulo Prodotti si realizza quando stai effettivamente creando una fattura o un preventivo.

- All'interno del generatore di fatture, invece di digitare nella riga vuota, fai clic sul menu a discesa **"Aggiungi prodotto"**.
- Seleziona il tuo articolo preconfigurato.
- Il sistema popola istantaneamente la descrizione, imposta il prezzo unitario, applica l'imposta corretta e calcola il totale della riga. 
- La creazione di una fattura complessa composta da 20 elementi richiede solo pochi secondi anziché diversi minuti di immissione manuale dei dati.

---

## 4. Modifica e adeguamento dei costi
I prezzi evolvono nel tempo in base ai costi dei fornitori o alla domanda del mercato.
- Puoi modificare liberamente il prezzo predefinito di qualsiasi articolo nel tuo catalogo principale in qualsiasi momento.
- **Integrità storica:** La modifica del prezzo di un articolo del catalogo *non* altera le vecchie fatture già inviate. I tuoi registri finanziari storici rimangono perfettamente intatti, mentre tutte le fatture appena generate erediteranno la logica dei prezzi aggiornata.