# Products & Inventory Control: Full Features Guide

Constantly re-typing the same item descriptions, prices, and tax rates every time you generate a bill is inefficient and prone to error. The **Products** module acts as your central catalog and basic inventory management system, designed to radically accelerate your invoicing workflow.

---

## 1. Creating Your Master Catalog
Navigate to the **Products** tab to begin building your database of goods and services.

### Standard Item Configuration
When defining a new product or service, you can configure several permanent defaults:
- **Item Name & Description:** Write a clear, professional description. This exact text will populate on the invoice line item, ensuring your clients always receive consistent explanations of what they are buying.
- **Default Unit Price:** Set your standard rate. Whether you charge $150/hour for consulting or $25 for a physical widget, saving it here means you never have to look up prices again.
- **Taxation Rules:** Different items often have different tax liabilities (e.g., physical goods might have a 10% Sales Tax, while digital services might be tax-exempt). You can assign a specific *Default Tax Rate* to an item. When you add this item to an invoice, the system automatically applies the correct tax math without you lifting a finger.

---

## 2. Automated Stock and Inventory Management
If your business sells physical goods rather than abstract services, tracking exactly how many items you have left in the warehouse is critical. The platform features an automated micro-inventory system.

### Enabling Stock Tracking
When creating or editing a physical product, simply toggle the **"Manage Stock"** switch to the ON position.
- You will be prompted to enter your **Current Quantity on Hand** (e.g., 500 units).
- This establishes your baseline inventory for this specific SKU.

### Real-Time Auto-Deduction
The magic of the inventory system happens during the billing phase entirely automatically.
- Whenever you finalize and send an **Invoice** that contains a stock-managed product, the system immediately reads the quantity billed on that invoice and deducts it from your master database.
- *Example:* If you have 500 widgets, and you send an invoice billing a client for 50 widgets, your master stock automatically drops to 450.
- This ensures you never accidentally oversell an item you no longer possess. 
- *Note:* Estimates do not deduct stock, as they are not finalized sales. Only active, sent invoices trigger the deduction logic.

---

## 3. Rapid Invoicing Integration
The true power of the Products module is realized when you are actually building an invoice or quote.

- Inside the Invoice Builder, instead of typing into the blank row, click the **"Add Product"** dropdown menu.
- Select your pre-configured item.
- The system instantaneously populates the description, sets the unit price, applies the correct tax, and calculates the row total. 
- Building a complex, 20-item invoice takes mere seconds instead of several minutes of manual data entry.

---

## 4. Editing and Cost Adjustments
Prices evolve over time based on supplier costs or market demand.
- You can freely edit the default price of any item in your master catalog at any time.
- **Historical Integrity:** Modifying the price of a catalog item *does not* alter old, already-sent invoices. Your historical financial records remain perfectly intact, while all newly generated invoices will inherit the updated pricing logic.
