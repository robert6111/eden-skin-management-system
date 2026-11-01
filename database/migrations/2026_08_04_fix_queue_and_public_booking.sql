-- Run this once only if you already installed the previous ZIP before this fix.
-- Fresh installations do not need this file because database/schema.sql already contains these columns.

ALTER TABLE queues ADD COLUMN appointment_id INT NULL AFTER visit_id;
ALTER TABLE queues ADD COLUMN service_id INT NULL AFTER queue_number;
ALTER TABLE queues MODIFY status ENUM('waiting','called','in_service','completed','cancelled','no_show') DEFAULT 'waiting';

-- Optional indexes for faster queue lookup.
CREATE INDEX idx_queues_appointment ON queues(appointment_id);
CREATE INDEX idx_queues_service ON queues(service_id);
