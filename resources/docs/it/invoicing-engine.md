# Il motore di fatturazione: una guida completa

La logica principale di questa piattaforma ruota attorno a un motore di fatturazione automatizzato e altamente avanzato, progettato per aiutarti a generare fatture professionali in modo completamente fluido. Questa guida copre il set completo di funzionalità disponibili nel flusso di generazione della fattura.

---

## 1. Avvio di una nuova fattura
Creare una fattura è semplice. Passa al modulo **Fatture** e fai clic su **Crea nuova fattura**. 
Questo avvia il generatore di documenti interattivo con trascinamento della selezione.

### Metadati della fattura
Prima di aggiungere elementi pubblicitari, imposterai i metadati principali che definiscono il documento:
- **Numero fattura:** Per impostazione predefinita, il sistema incrementa automaticamente i numeri delle fatture (ad esempio, INV-0001 diventa INV-0002). Tuttavia, puoi sovrascrivere manualmente il prefisso e lo schema di numerazione nelle impostazioni globali se utilizzi un formato personalizzato.
- **Data di emissione:** La data in cui il documento è stato ufficialmente generato. Default ad oggi.
- **Data di scadenza/Termini di pagamento:** Definisci quando prevedi di ricevere il denaro. Puoi selezionare date esatte o utilizzare termini dinamici come "15 netto", "30 netto" o "Scadenza alla ricezione". Il sistema calcolerà automaticamente la data di scadenza esatta in base alla data di emissione.
- **Selezione del cliente:** seleziona un cliente esistente dal tuo CRM o definiscine rapidamente uno nuovo in linea senza uscire dal builder.

---

## 2. Gestione delle voci
La sezione della voce è il luogo in cui costruisci la fattura vera e propria. 

### Aggiunta di prodotti e servizi
Puoi aggiungere elementi pubblicitari in due modi distinti:
1. **Inserimento manuale:** digita descrizioni completamente personalizzate, prezzi arbitrari e quantità specifiche direttamente in una riga vuota. Questo è perfetto per lavori di progetto personalizzati o costi di servizio unici.
2. **Dall'inventario:** fai clic sul menu a discesa "Aggiungi prodotto" per selezionare gli articoli pre-salvati dal catalogo Prodotti/Servizi. Il sistema inserirà immediatamente la descrizione predefinita, il prezzo unitario e le aliquote fiscali predefinite per quell'articolo, facendoti risparmiare tempo immenso.

### Matematica e tasse in tempo reale
L'intera tabella è matematicamente integrata.
- Man mano che modifichi le quantità o i prezzi unitari, i totali delle righe si aggiornano immediatamente.
- **Imposte sulle voci:** puoi assegnare più aliquote fiscali (ad esempio, un'IVA regionale e un'imposta sulle vendite secondaria) a una singola voce. Il sistema calcola queste tasse in modo dinamico e individuale per ogni riga.
- **Riordino tramite trascinamento:** prendi la maniglia sul lato sinistro di qualsiasi riga per riordinare il modo in cui appaiono gli elementi nel PDF finale. La matematica continua a calcolare perfettamente indipendentemente dall'ordine.

---

## 3. Sconti e modificatori globali
A volte è necessario modificare il totale complessivo oltre le singole voci.

- **Sconti globali:** nella parte inferiore del generatore di fatture, puoi inserire uno sconto globale. Puoi scegliere se questo sconto è un importo fisso letterale (ad esempio, "$ 50 di sconto") o una percentuale del totale parziale (ad esempio, "10% di sconto"). Il totale complessivo si aggiorna dinamicamente per riflettere i risparmi.
- **Note e termini:** aggiungi un messaggio personalizzato al cliente (come "Grazie per il tuo lavoro!") e definisci termini e condizioni legali rigorosi (come "I pagamenti ritardati comportano una penalità del 5%").

---

## 4. Invio e consegna
Una volta finalizzata la fattura, è il momento di essere pagato.

### Invio automatico di e-mail
Facendo clic su "Invia fattura" si apre l'Avvio e-mail.
- Il sistema carica automaticamente l'indirizzo email principale assegnato al tuo Cliente.
- Puoi personalizzare notevolmente la riga dell'oggetto e il corpo HTML dell'e-mail. Se hai definito un modello specifico per questo cliente nel CRM, verrà precaricato.
- La piattaforma allega un PDF del documento altamente compresso e splendidamente generato direttamente all'e-mail in uscita.

### Portale clienti "Magic Link"
Fondamentalmente, l'e-mail contiene anche un "collegamento magico". Quando il tuo cliente fa clic su questo collegamento, viene indirizzato direttamente al suo portale clienti sicuro e senza password dove può visualizzare la fattura in modo dinamico.

### Monitoraggio dello stato
Una volta inviata una fattura, il sistema inizia a tracciarne automaticamente lo stato:
- Vedrai esattamente quando il client apre l'e-mail e visualizza il documento online (lo stato cambia da Inviato a Visualizzato).
- Se la data di scadenza supera, il sistema contrassegna la fattura con un badge rosso **Scaduto**.
- Quando i pagamenti vengono registrati (manualmente o tramite Stripe), il saldo si aggiorna. Se pagato parzialmente, passa a “Parziale”. Se completamente saldato, viene archiviato come "Pagato".