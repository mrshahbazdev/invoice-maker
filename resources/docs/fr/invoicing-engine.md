# Le moteur de facturation : un guide complet

La logique de base de cette plateforme s'articule autour d'un moteur de facturation automatisé très avancé, conçu pour vous aider à générer une facturation professionnelle de manière totalement transparente. Ce guide couvre l'ensemble complet des fonctionnalités disponibles dans le flux de génération de factures.

---

## 1. Initier une nouvelle facture
Créer une facture est simple. Accédez à votre module **Factures** et cliquez sur **Créer une nouvelle facture**. 
Cela lance le générateur de documents interactif par glisser-déposer.

### Métadonnées de la facture
Avant d'ajouter des éléments de campagne, vous allez configurer les métadonnées principales qui définissent le document :
- **Numéro de facture :** Par défaut, le système incrémente automatiquement vos numéros de facture (par exemple, INV-0001 devenant INV-0002). Cependant, vous pouvez remplacer manuellement le préfixe et le schéma de numérotation dans vos paramètres globaux si vous utilisez un format personnalisé.
- **Date d'émission :** La date à laquelle le document est officiellement généré. La valeur par défaut est aujourd'hui.
- **Date d'échéance / Conditions de paiement :** Définissez la date à laquelle vous prévoyez recevoir l'argent. Vous pouvez sélectionner des dates exactes ou utiliser des termes dynamiques tels que « Net 15 », « Net 30 » ou « Due on Receipt ». Le système calculera automatiquement la date d'échéance exacte en fonction de la date d'émission.
- **Sélection du client :** Sélectionnez un client existant dans votre CRM ou définissez-en rapidement un nouveau en ligne sans quitter le constructeur.

---

## 2. Gestion des éléments de campagne
La section des éléments de campagne est l'endroit où vous construisez la facture réelle. 

### Ajout de produits et de services
Vous pouvez ajouter des éléments de campagne de deux manières distinctes :
1. **Saisie manuelle :** Saisissez des descriptions entièrement personnalisées, des prix arbitraires et des quantités spécifiques directement dans une ligne vide. C’est parfait pour les projets personnalisés ou les frais de service uniques.
2. **Depuis l'inventaire :** Cliquez sur le menu déroulant « Ajouter un produit » pour sélectionner les articles pré-enregistrés dans votre catalogue de produits/services. Le système injectera instantanément la description prédéfinie, le prix unitaire et les taux de taxe par défaut pour cet article, vous faisant ainsi gagner un temps considérable.

### Mathématiques et impôts en temps réel
L'ensemble du tableau est mathématiquement intégré.
- Lorsque vous ajustez les quantités ou les prix unitaires, les totaux des lignes sont mis à jour instantanément.
- **Taxes sur les éléments de campagne :** Vous pouvez attribuer plusieurs taux de taxe (par exemple, une TVA régionale et une taxe de vente secondaire) à un seul élément de campagne. Le système calcule ces taxes de manière dynamique et individuellement pour chaque ligne.
- **Réorganisation par glisser-déposer :** Saisissez la poignée située sur le côté gauche de n'importe quelle ligne pour réorganiser la façon dont les éléments apparaissent sur le PDF final. Les mathématiques continuent de calculer parfaitement quel que soit l'ordre.

---

## 3. Remises et modificateurs globaux
Parfois, vous devez ajuster le total général au-delà des éléments de campagne individuels.

- **Remises globales :** Au bas du générateur de factures, vous pouvez injecter une remise globale. Vous pouvez choisir si cette remise correspond à un montant fixe littéral (par exemple, « 50 $ de réduction ») ou à un pourcentage du sous-total (par exemple, « 10 % de réduction »). Le total général est mis à jour dynamiquement pour refléter les économies.
- **Remarques et conditions :** Ajoutez un message personnalisé au client (tel que "Merci pour votre entreprise !") et définissez des conditions générales juridiques strictes (telles que "Les paiements en retard entraînent une pénalité de 5 %").

---

## 4. Envoi et livraison
Une fois votre facture finalisée, il est temps d'être payée.

### Envoi automatisé d'e-mails
Cliquer sur « Envoyer la facture » ouvre le lanceur d'e-mails.
- Le système charge automatiquement l'adresse e-mail principale attribuée à votre client.
- Vous pouvez fortement personnaliser la ligne d'objet et le corps HTML de l'e-mail. Si vous avez défini un modèle spécifique pour ce client dans le CRM, il sera préchargé.
- La plateforme joint un PDF du document hautement compressé et magnifiquement généré directement à l'e-mail sortant.

### Portail client "Magic Link"
Surtout, l'e-mail contient également un "Magic Link". Lorsque votre client clique sur ce lien, il est directement redirigé vers son portail client sécurisé et sans mot de passe où il peut consulter la facture de manière dynamique.

### Suivi du statut
Une fois qu'une facture est envoyée, le système commence automatiquement à suivre son statut :
- Vous verrez exactement quand le client ouvre l'e-mail et consulte le document en ligne (le statut passe de Envoyé à Consulté).
- Si la date d'échéance est dépassée, le système signale la facture avec un badge **En retard** rouge vif.
- Lorsque les paiements sont enregistrés (soit manuellement, soit via Stripe), le solde est mis à jour. S'il est partiellement payé, il passe à "Partiel". S'il est entièrement réglé, il est archivé comme « Payé ».