-- =====================================================
-- CHECK AUTHENTICATION CONFIGURATION
-- =====================================================

-- 1. Cek user table structure
DESCRIBE users;

-- 2. Cek user data
SELECT id, name, email, password, created_at FROM users WHERE email = 'gmaramis@kairosmanado.id';

-- 3. Cek apakah ada user lain
SELECT id, name, email, created_at FROM users;

-- 4. Cek password hash length (harus 60 karakter)
SELECT email, LENGTH(password) as password_length FROM users WHERE email = 'gmaramis@kairosmanado.id';
