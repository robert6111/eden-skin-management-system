# Service Product Consumption Guide

This system treats each service like a recipe.

When the cashier sells a service in POS, the system reduces the products linked to that service automatically. The cashier does not need to select those products again unless the customer is buying a product to take home.

## Where to manage it

Open:

`Services & Stock → Product Consumption`

There are two tabs:

1. **All Service Recipes** — shows every service and what products will be deducted.
2. **Manage One Service** — lets the owner change the product consumption logic for a selected service.

## How to understand the quantity

- `1.000 piece / pack / pair` means one full item is deducted.
- `0.100 bottle / jar / tub` means 10% of one bottle, jar, or tub is deducted.
- `10.000 piece` means ten pieces are deducted.

Example:

Massage Oil stock is 18 bottles. Full Body Massage uses 0.100 bottle. After one massage:

`18.000 - 0.100 = 17.900 bottles`

## Applying the recommended setup to an existing installation

Open `Product Consumption` and click:

- **Add Missing Recommended Setup** to add only missing products and rules while keeping your existing custom quantities.
- **Reset to Recommended Quantities** only when you want the system to replace your existing quantities with the recommended setup.

Fresh installations already include the expanded recommended product consumption setup in the seed data.
