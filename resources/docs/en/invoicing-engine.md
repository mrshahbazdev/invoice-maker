# The Invoicing Engine: A Complete Guide

The core logic of this platform revolves around a highly advanced, automated Invoicing Engine designed to help you generate professional billing completely seamlessly. This guide covers the complete feature set available within the Invoice generation flow.

---

## 1. Initiating a New Invoice
Creating an invoice is straightforward. Navigate to your **Invoices** module and click **Create New Invoice**. 
This launches the interactive, drag-and-drop document builder.

### Invoice Metadata
Before adding line items, you'll set up the core metadata that defines the document:
- **Invoice Number:** By default, the system auto-increments your invoice numbers (e.g., INV-0001 becoming INV-0002). However, you can manually override the prefix and numbering scheme in your global settings if you utilize a custom format.
- **Issue Date:** The date the document is officially generated. Defaults to today.
- **Due Date / Payment Terms:** Define when you expect to receive the money. You can select exact dates or use dynamic terms like "Net 15", "Net 30", or "Due on Receipt." The system will automatically calculate the exact due date based on the issue date.
- **Client Selection:** Select an existing client from your CRM or quickly define a new one inline without leaving the builder.

---

## 2. Managing Line Items
The line item section is where you construct the actual bill. 

### Adding Products and Services
You can add line items in two distinct ways:
1. **Manual Entry:** Type completely custom descriptions, arbitrary prices, and specific quantities directly into an empty row. This is perfect for custom project work or unique service fees.
2. **From Inventory:** Click the "Add Product" dropdown to select pre-saved items from your Products/Services catalog. The system will instantly inject the predefined description, unit price, and default tax rates for that item, saving you immense time.

### Real-Time Math and Taxes
The entire table is mathematically integrated.
- As you adjust quantities or unit prices, the row totals update instantly.
- **Line Item Taxes:** You can assign multiple tax rates (e.g., a regional VAT and a secondary Sales Tax) to a single line item. The system calculates these taxes dynamically and individually for every row.
- **Drag and Drop Reordering:** Grab the handle on the left side of any row to reorder how the items appear on the final PDF. The math continues to calculate perfectly regardless of ordering.

---

## 3. Discounts and Global Modifiers
Sometimes you need to adjust the grand total beyond the individual line items.

- **Global Discounts:** At the bottom of the invoice builder, you can inject a global discount. You can choose whether this discount is a literal fixed amount (e.g., "$50 off") or a percentage of the subtotal (e.g., "10% off"). The grand total updates dynamically to reflect the savings.
- **Notes and Terms:** Add a personalized message to the client (such as "Thank you for your business!") and define strict Legal Terms and Conditions (such as "Late payments incur a 5% penalty").

---

## 4. Sending and Delivery
Once your invoice is finalized, it's time to get paid.

### Automated Email Dispatching
Clicking "Send Invoice" opens the Email Launcher.
- The system automatically loads the primary email address assigned to your Client.
- You can heavily customize the Subject Line and the HTML body of the email. If you have defined a specific template for this client in the CRM, it will be pre-loaded.
- The platform attaches a highly compressed, beautifully generated PDF of the document directly to the outgoing email.

### Client Portal "Magic Link"
Crucially, the email also contains a "Magic Link". When your client clicks this link, they are taken directly to their secure, passwordless Client Portal where they can view the invoice dynamically.

### Status Tracking
Once an invoice is sent, the system begins tracking its status automatically:
- You will see exactly when the client opens the email and views the document online (Status changes from Sent to Viewed).
- If the Due Date passes, the system flags the invoice with a stark red **Overdue** badge.
- When payments are logged (either manually or via Stripe), the balance updates. If partially paid, it moves to "Partial". If fully settled, it is archived as "Paid."
