# Accounting & Cash Book

Your complete financial ledger. Double-entry bookkeeping made completely automated.

## The Cash Book Ledger
Found under **Accounting > Cash Book**, this ledger lists every single cash flow event for your business.
- **Income Events:** Whenever an invoice is marked as Paid (manually or via Stripe), an Income record is automatically generated here.
- **Expense Events:** Whenever an expense is logged, an Outbound record is generated here.

## Bank Reconciliation (Automated CSV Import)
The application supports fully automated Bank Reconciliation via CSV imports.
1. **Multi-Step Import Wizard:** Upload your bank statement CSV file.
2. **Map Columns:** Tell the system which column represents the Date, Description, and Amount. The UI provides a live data preview.
3. **Smart Auto-Matching Engine:** The backend engine intelligently parses every row.
   - **Income:** Scans unpaid invoices. Matches based on exact totals or invoice numbers found in descriptions.
   - **Expenses:** Scans existing unlinked expenses. Matches based on amounts or reference numbers.
4. **Accounting Ledger Sync:** When confirmed, the system converts these matches into actual Payments (marking invoices as Paid) and inserts all transactions directly into your Cash Book.

## AI Health Checks & Insights
Get specific, high-level AI insights generated exclusively on your cash book health. The AI looks at cash-in vs cash-out patterns, high category spends, and unpaid balances to provide actionable advice.

## Reporting & Exports
Need to hand off your books to an accountant? You can export your current Cash Book view to **Excel/CSV** or heavily formatted **PDF** documents with one click.
