# Produits et contrôle des stocks : guide complet des fonctionnalités

Retaper constamment les mêmes descriptions d'articles, prix et taux de taxe à chaque fois que vous générez une facture est inefficace et sujet aux erreurs. Le module **Produits** fait office de catalogue central et de système de gestion des stocks de base, conçu pour accélérer radicalement votre flux de facturation.

---

## 1. Création de votre catalogue principal
Accédez à l'onglet **Produits** pour commencer à créer votre base de données de biens et services.

### Configuration de l'élément standard
Lors de la définition d'un nouveau produit ou service, vous pouvez configurer plusieurs valeurs par défaut permanentes :
- **Nom et description de l'article :** Rédigez une description claire et professionnelle. Ce texte exact apparaîtra sur la ligne de facture, garantissant ainsi à vos clients de toujours recevoir des explications cohérentes sur ce qu'ils achètent.
- **Prix unitaire par défaut :** Définissez votre tarif standard. Que vous facturiez 150 $/heure pour une consultation ou 25 $ pour un widget physique, l'enregistrer ici signifie que vous n'aurez plus jamais à rechercher les prix.
- **Règles fiscales :** Différents articles sont souvent soumis à des obligations fiscales différentes (par exemple, les biens physiques peuvent être soumis à une taxe de vente de 10 %, tandis que les services numériques peuvent être exonérés de taxe). Vous pouvez attribuer un *Taux de taxe par défaut* spécifique à un article. Lorsque vous ajoutez cet élément à une facture, le système applique automatiquement le calcul fiscal correct sans que vous leviez le petit doigt.

---

## 2. Gestion automatisée des stocks et des stocks
Si votre entreprise vend des biens physiques plutôt que des services abstraits, il est essentiel de suivre exactement le nombre d'articles qu'il vous reste dans l'entrepôt. La plateforme dispose d'un système automatisé de micro-inventaire.

### Activation du suivi des stocks
Lors de la création ou de la modification d'un produit physique, basculez simplement le commutateur **"Gérer le stock"** sur la position ON.
- Vous serez invité à saisir votre **Quantité actuelle en main** (par exemple, 500 unités).
- Cela établit votre inventaire de référence pour ce SKU spécifique.

### Déduction automatique en temps réel
La magie du système d’inventaire se produit pendant la phase de facturation de manière entièrement automatique.
- Chaque fois que vous finalisez et envoyez une **Facture** contenant un produit géré en stock, le système lit immédiatement la quantité facturée sur cette facture et la déduit de votre base de données principale.
- *Exemple :* Si vous disposez de 500 widgets et que vous envoyez une facture facturant à un client 50 widgets, votre stock principal descend automatiquement à 450.
- Cela garantit que vous ne revendez jamais accidentellement un article que vous ne possédez plus. 
- *Remarque :* Les estimations ne déduisent pas le stock, car il ne s'agit pas de ventes finalisées. Seules les factures actives envoyées déclenchent la logique de déduction.

---

## 3. Intégration rapide de la facturation
La véritable puissance du module Produits se réalise lorsque vous créez réellement une facture ou un devis.

- Dans Invoice Builder, au lieu de taper dans la ligne vide, cliquez sur le menu déroulant **"Ajouter un produit"**.
- Sélectionnez votre élément préconfiguré.
- Le système remplit instantanément la description, fixe le prix unitaire, applique la taxe correcte et calcule le total de la ligne. 
- La création d'une facture complexe de 20 éléments ne prend que quelques secondes au lieu de plusieurs minutes de saisie manuelle des données.

---

## 4. Édition et ajustements des coûts
Les prix évoluent dans le temps en fonction des coûts des fournisseurs ou de la demande du marché.
- Vous pouvez librement modifier le prix par défaut de n'importe quel article de votre catalogue principal à tout moment.
- **Intégrité historique :** La modification du prix d'un article du catalogue *ne modifie pas* les anciennes factures déjà envoyées. Vos dossiers financiers historiques restent parfaitement intacts, tandis que toutes les factures nouvellement générées hériteront de la logique de tarification mise à jour.