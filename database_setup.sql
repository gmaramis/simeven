-- =====================================================
-- SETUP DATABASE GSJA KAIROS MANADO EVENT SYSTEM
-- =====================================================

-- 1. INSERT ADMIN USER
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('Admin GSJA Kairos', 'gmaramis@kairosmanado.id', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW());

-- 2. INSERT SAMPLE EVENTS
INSERT INTO `events` (`title`, `description`, `date`, `time`, `location`, `capacity`, `image`, `status`, `created_at`, `updated_at`) VALUES
('Seminar Rohani GSJA Kairos Manado', 'Seminar rohani untuk memperdalam iman dan pengetahuan alkitabiah. Acara ini akan membahas topik-topik penting dalam kehidupan kristen dan memberikan wawasan baru untuk pertumbuhan rohani.', '2025-09-15', '09:00:00', 'Graha Kairos Lt 1, Manado', 100, 'events/seminar-rohani.jpg', 'active', NOW(), NOW()),
('Workshop Worship Leader', 'Workshop khusus untuk worship leader dan tim musik. Belajar teknik vokal, arrangement musik, dan leadership dalam worship.', '2025-09-20', '14:00:00', 'Graha Kairos Lt 2, Manado', 50, 'events/workshop-worship.jpg', 'active', NOW(), NOW()),
('Retreat Pemuda GSJA Kairos', 'Retreat 2 hari 1 malam untuk pemuda GSJA Kairos Manado. Acara ini akan membangun persaudaraan dan memperdalam hubungan dengan Tuhan.', '2025-10-05', '08:00:00', 'Villa Bukit Manado', 75, 'events/retreat-pemuda.jpg', 'active', NOW(), NOW()),
('Konser Pujian dan Penyembahan', 'Konser pujian dan penyembahan yang menghadirkan berbagai lagu rohani terbaik. Acara ini terbuka untuk umum dan akan menjadi momen yang memberkati.', '2025-10-12', '19:00:00', 'Graha Kairos Lt 1, Manado', 200, 'events/konser-pujian.jpg', 'active', NOW(), NOW()),
('Seminar Keluarga Kristen', 'Seminar tentang membangun keluarga yang berlandaskan firman Tuhan. Acara ini akan memberikan panduan praktis untuk keluarga kristen.', '2025-10-19', '09:00:00', 'Graha Kairos Lt 1, Manado', 80, 'events/seminar-keluarga.jpg', 'active', NOW(), NOW());

-- 3. INSERT SAMPLE REGISTRATIONS (Optional - untuk testing)
INSERT INTO `registrations` (`event_id`, `name`, `phone`, `church`, `ministry`, `notes`, `status`, `checkin_time`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', '081234567890', 'GSJA Kairos Manado', 'Gembala Sidang', 'Sangat tertarik dengan topik yang akan dibahas', 'confirmed', NULL, NOW(), NOW()),
(1, 'Jane Smith', '081234567891', 'GSJA Kairos Manado', 'Worship Leader', 'Mengikuti untuk memperdalam pengetahuan', 'confirmed', NULL, NOW(), NOW()),
(2, 'Mike Johnson', '081234567892', 'GSJA Kairos Manado', 'Tim Musik', 'Ingin belajar teknik arrangement', 'confirmed', NULL, NOW(), NOW()),
(3, 'Sarah Wilson', '081234567893', 'GSJA Kairos Manado', 'Pengerja', 'Mengikuti retreat untuk refreshing rohani', 'confirmed', NULL, NOW(), NOW()),
(4, 'David Brown', '081234567894', 'GSJA Kairos Manado', 'Singers', 'Sangat antusias dengan konser ini', 'confirmed', NULL, NOW(), NOW());

-- 4. INSERT SAMPLE WHATSAPP MESSAGES (Optional - untuk testing)
INSERT INTO `whatsapp_messages` (`registration_id`, `phone`, `message_type`, `message_content`, `status`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, '081234567890', 'confirmation', 'Terima kasih telah mendaftar untuk Seminar Rohani GSJA Kairos Manado. Acara akan dilaksanakan pada 15 September 2025 pukul 09.00 WITA di Graha Kairos Lt 1, Manado. Silakan datang 30 menit sebelum acara dimulai.', 'sent', NOW(), NOW(), NOW()),
(2, '081234567891', 'confirmation', 'Terima kasih telah mendaftar untuk Seminar Rohani GSJA Kairos Manado. Acara akan dilaksanakan pada 15 September 2025 pukul 09.00 WITA di Graha Kairos Lt 1, Manado. Silakan datang 30 menit sebelum acara dimulai.', 'sent', NOW(), NOW(), NOW()),
(3, '081234567892', 'confirmation', 'Terima kasih telah mendaftar untuk Workshop Worship Leader. Acara akan dilaksanakan pada 20 September 2025 pukul 14.00 WITA di Graha Kairos Lt 2, Manado. Silakan datang 30 menit sebelum acara dimulai.', 'sent', NOW(), NOW(), NOW());

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Cek admin user
-- SELECT * FROM users WHERE email = 'gmaramis@kairosmanado.id';

-- Cek events
-- SELECT * FROM events;

-- Cek registrations
-- SELECT * FROM registrations;

-- Cek whatsapp messages
-- SELECT * FROM whatsapp_messages;

-- =====================================================
-- LOGIN CREDENTIALS
-- =====================================================
-- Email: gmaramis@kairosmanado.id
-- Password: password
