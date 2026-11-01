# Hotfix: Automatic Ngrok WhatsApp Booking Link

This update automates the Ngrok booking-link process.

## What changed

- When Ngrok is running with `ngrok http 80`, the booking-link screen automatically reads the active Ngrok HTTPS URL from the local Ngrok inspector API on port `4040`.
- The WhatsApp message uses the detected Ngrok booking URL automatically.
- Staff no longer need to copy the Ngrok URL manually or replace `localhost`.
- The visible booking-link screen shows whether Ngrok was detected.
- The WhatsApp button still uses the same click-to-chat style copied from the Bus Owner Control System.

## How to use

1. Start XAMPP Apache and MySQL.
2. Start Ngrok:

   ```cmd
   ngrok http 80
   ```

3. Open the salon system locally:

   ```text
   http://localhost/salon_spa_management_system/modules/booking_link.php
   ```

4. The page should show **Ngrok detected automatically**.
5. Select a customer or type the WhatsApp number.
6. Click **Open WhatsApp and Send Booking Link**.

The message sent to WhatsApp will contain the public Ngrok booking link automatically.

## Important

Keep the Ngrok Command Prompt window open. If Ngrok is restarted and the free URL changes, refresh the booking-link page before sending new messages.

If you later set **Business Settings → Public Booking Base URL**, that manual value will override automatic Ngrok detection. Use that only when you have a permanent domain or static tunnel URL.
