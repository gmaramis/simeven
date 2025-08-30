# 🚀 Deployment Guide - GSJA Kairos Event Management

## 📋 Prerequisites

### 1. Hostinger Setup
- ✅ Domain: `kairosmanado.id`
- ✅ Subdomain: `event.kairosmanado.id`
- ✅ Hosting plan dengan PHP 8.2+ support
- ✅ MySQL database
- ✅ SSH access (optional, untuk advanced deployment)

### 2. GitHub Repository
- ✅ Repository: `https://github.com/gmaramis/simeven`
- ✅ Branch: `main`

## 🔧 Setup GitHub Secrets

### 1. Buka GitHub Repository Settings
```
https://github.com/gmaramis/simeven/settings/secrets/actions
```

### 2. Tambahkan Secrets Berikut:

#### **FTP Credentials:**
```
FTP_SERVER = your-ftp-server.hostinger.com
FTP_USERNAME = your-ftp-username
FTP_PASSWORD = your-ftp-password
```

#### **SSH Credentials (Optional):**
```
SSH_HOST = your-ssh-host.hostinger.com
SSH_USERNAME = your-ssh-username
SSH_PRIVATE_KEY = your-ssh-private-key
```

## 🗄️ Database Setup

### 1. Buat Database di Hostinger
- Database name: `kairos_event_db`
- Username: `kairos_event_user`
- Password: `strong_password_here`

### 2. Import Database Schema
```sql
-- Jalankan migration di local dulu
php artisan migrate

-- Export database
mysqldump -u root -p event-kairos > database_backup.sql

-- Import ke Hostinger
mysql -u kairos_event_user -p kairos_event_db < database_backup.sql
```

## 🌐 Domain & Subdomain Setup

### 1. Subdomain Configuration
```
event.kairosmanado.id → /public_html/event.kairosmanado.id/
```

### 2. SSL Certificate
- Aktifkan SSL untuk subdomain
- Redirect HTTP ke HTTPS

## ⚙️ Environment Configuration

### 1. Production Environment File
Buat file `.env` di root project dengan konfigurasi:

```env
APP_NAME="GSJA Kairos Event Management"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://event.kairosmanado.id

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=kairos_event_db
DB_USERNAME=kairos_event_user
DB_PASSWORD=your_database_password

# WhatsApp Fonnte Configuration
FONNTE_API_TOKEN=2d3Ys4hQay3mHSmCVkPR
FONNTE_API_URL=https://api.fonnte.com
WHATSAPP_ENABLED=true
```

### 2. Generate App Key
```bash
php artisan key:generate
```

## 🚀 Deployment Process

### 1. Automatic Deployment
Setiap push ke branch `main` akan trigger deployment otomatis.

### 2. Manual Deployment
Buka GitHub Actions → Deploy to Hostinger → Run workflow

### 3. Deployment Steps
1. ✅ Checkout code dari GitHub
2. ✅ Install PHP dependencies
3. ✅ Install Node.js dependencies
4. ✅ Build assets (CSS/JS)
5. ✅ Create deployment package
6. ✅ Upload ke Hostinger via FTP
7. ✅ Execute deployment script
8. ✅ Clear Laravel caches

## 📁 File Structure di Hostinger

```
public_html/event.kairosmanado.id/
├── current/                 # Current version
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/             # Document root
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── artisan
├── backup/                 # Previous version
├── deploy.sh              # Deployment script
└── .htaccess              # Apache configuration
```

## 🔒 Security Configuration

### 1. File Permissions
```bash
chmod -R 755 current/
chmod -R 775 current/storage/
chmod -R 775 current/bootstrap/cache/
```

### 2. Environment Protection
- `.env` file tidak di-upload ke server
- Sensitive data disimpan di GitHub Secrets

## 📊 Monitoring & Maintenance

### 1. Log Files
```
current/storage/logs/laravel.log
```

### 2. Cache Management
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Database Backup
```bash
# Backup database
mysqldump -u kairos_event_user -p kairos_event_db > backup_$(date +%Y%m%d).sql
```

## 🆘 Troubleshooting

### 1. Deployment Failed
- ✅ Check GitHub Actions logs
- ✅ Verify FTP credentials
- ✅ Check file permissions
- ✅ Verify database connection

### 2. Application Errors
- ✅ Check Laravel logs
- ✅ Verify environment variables
- ✅ Check database connectivity
- ✅ Verify SSL certificate

### 3. Performance Issues
- ✅ Enable Laravel caching
- ✅ Optimize database queries
- ✅ Enable CDN for assets
- ✅ Monitor server resources

## 📞 Support

Jika ada masalah deployment, hubungi:
- **GitHub Issues:** https://github.com/gmaramis/simeven/issues
- **Email:** gmaramis@kairosmanado.id

---

**🎯 Deployment siap! Setiap push ke main branch akan otomatis deploy ke event.kairosmanado.id**
