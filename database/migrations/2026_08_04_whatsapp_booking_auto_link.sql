-- Hotfix: WhatsApp booking sender uses automatic customer booking link
-- Run this only if you already installed an older version.
INSERT INTO settings(branch_id,setting_key,setting_value,setting_group)
SELECT 1,'whatsapp_country_code','255','notifications'
WHERE NOT EXISTS (SELECT 1 FROM settings WHERE branch_id=1 AND setting_key='whatsapp_country_code');

INSERT INTO settings(branch_id,setting_key,setting_value,setting_group)
SELECT 1,'public_booking_base_url','','notifications'
WHERE NOT EXISTS (SELECT 1 FROM settings WHERE branch_id=1 AND setting_key='public_booking_base_url');
