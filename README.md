# 🎉 Event Management System - GSJA Kairos Manado

Sistem manajemen event untuk Gereja GSJA Kairos Manado yang memungkinkan pendaftaran event, check-in peserta, dan integrasi WhatsApp untuk notifikasi otomatis.

## ✨ Fitur Utama

### 🎯 **Event Management**
- ✅ Buat, edit, dan kelola event
- ✅ Status event (Draft, Published, Ongoing, Completed)
- ✅ Manajemen seat/kursi tersedia
- ✅ Upload gambar event

### 👥 **Registration System**
- ✅ Pendaftaran publik via website
- ✅ Form pendaftaran dengan validasi WhatsApp
- ✅ Auto-confirmation untuk pendaftaran publik
- ✅ Admin dapat mengelola pendaftaran

### 📱 **WhatsApp Integration**
- ✅ Integrasi dengan Fonnte API
- ✅ Auto-send konfirmasi pendaftaran
- ✅ Reminder otomatis (H-1, H-0)
- ✅ Dashboard monitoring WhatsApp
- ✅ Tracking quota dan status device

### 🔍 **Check-in System**
- ✅ Interface check-in mobile-friendly
- ✅ Search peserta berdasarkan nomor WhatsApp
- ✅ Real-time stats dan dashboard
- ✅ Multiple check-in points

### 🗑️ **Bulk Operations**
- ✅ Bulk delete peserta
- ✅ Select all/none functionality
- ✅ Confirmation dialog
- ✅ Auto seat management

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x
- **Frontend:** Tailwind CSS, Alpine.js
- **Database:** MySQL
- **WhatsApp API:** Fonnte
- **Authentication:** Laravel Breeze

## 📋 Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM
- Fonnte Account (untuk WhatsApp integration)

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/event-kairos-manado.git
cd event-kairos-manado
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_kairos_manado
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. WhatsApp Configuration (Optional)
```env
FONNTE_API_TOKEN=your_fonnte_token
FONNTE_API_URL=https://api.fonnte.com
WHATSAPP_ENABLED=true
```

### 6. Database Migration & Seeding
```bash
php artisan migrate
php artisan db:seed
```

### 7. Storage Setup
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
npm run build
```

### 9. Start Server
```bash
php artisan serve
```

## 👤 Default Admin Account

- **Email:** `gmaramis@kairosmanado.id`
- **Password:** `password`

## 📱 WhatsApp Integration Setup

### 1. Fonnte Account
1. Daftar di [Fonnte](https://fonnte.com)
2. Hubungkan device WhatsApp
3. Dapatkan API token

### 2. Environment Variables
```env
FONNTE_API_TOKEN=your_token_here
FONNTE_API_URL=https://api.fonnte.com
WHATSAPP_ENABLED=true
```

### 3. Test Integration
```bash
php artisan whatsapp:test 081234567890
```

## 🎯 Usage

### Admin Panel
- **Dashboard:** `http://localhost:8000/admin`
- **Events:** `http://localhost:8000/admin/events`
- **Registrations:** `http://localhost:8000/admin/registrations`
- **Check-in:** `http://localhost:8000/admin/checkin`
- **WhatsApp:** `http://localhost:8000/admin/whatsapp`

### Public Website
- **Homepage:** `http://localhost:8000`
- **Events:** `http://localhost:8000/events`
- **Contact:** `http://localhost:8000/contact`

## 🌐 Production Deployment

### Automatic Deployment to Hostinger
This application is configured for automatic deployment to `event.kairosmanado.id` using GitHub Actions.

#### **Prerequisites:**
- ✅ Hostinger hosting account
- ✅ Subdomain: `event.kairosmanado.id`
- ✅ MySQL database
- ✅ FTP/SSH access

#### **Setup Steps:**

1. **Configure GitHub Secrets**
   ```
   Go to: https://github.com/gmaramis/simeven/settings/secrets/actions
   
   Add these secrets:
   - FTP_SERVER: your-ftp-server.hostinger.com
   - FTP_USERNAME: your-ftp-username
   - FTP_PASSWORD: your-ftp-password
   ```

2. **Database Setup**
   ```bash
   # Export local database
   ./scripts/export-database.sh
   
   # Import to Hostinger via phpMyAdmin
   ```

3. **Automatic Deployment**
   - Every push to `main` branch triggers deployment
   - Manual deployment available via GitHub Actions

#### **Production URLs:**
- **Public Website:** https://event.kairosmanado.id
- **Admin Panel:** https://event.kairosmanado.id/admin
- **Default Admin:** gmaramis@kairosmanado.id / password

📖 **Detailed deployment guide:** [DEPLOYMENT.md](DEPLOYMENT.md)

## 🔧 Commands

### WhatsApp Commands
```bash
# Test WhatsApp integration
php artisan whatsapp:test 081234567890

# Send reminders manually
php artisan whatsapp:send-reminders --type=h1
php artisan whatsapp:send-reminders --type=h0
```

### Maintenance Commands
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan optimize
```

## 📊 Database Structure

### Main Tables
- `events` - Data event
- `registrations` - Data pendaftaran
- `users` - Admin users
- `whatsapp_messages` - Log pesan WhatsApp

### Key Relationships
- Event → Registrations (One-to-Many)
- Registration → WhatsApp Messages (One-to-Many)
- User → Events (One-to-Many)

## 🔒 Security Features

- ✅ CSRF Protection
- ✅ Input Validation
- ✅ SQL Injection Prevention
- ✅ XSS Protection
- ✅ Authentication & Authorization
- ✅ Rate Limiting

## 📈 Performance Optimization

- ✅ Database Indexing
- ✅ Query Optimization
- ✅ Asset Minification
- ✅ Caching Strategies
- ✅ Lazy Loading

## 🐛 Troubleshooting

### Common Issues

#### 1. WhatsApp Integration Not Working
```bash
# Check Fonnte API status
php artisan whatsapp:test 081234567890

# Check environment variables
php artisan config:cache
```

#### 2. Database Connection Issues
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();
```

#### 3. Storage Issues
```bash
# Recreate storage link
php artisan storage:link

# Check permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

- **Email:** support@kairosmanado.id
- **WhatsApp:** 085240543123
- **Website:** https://kairosmanado.id

## 🙏 Acknowledgments

- GSJA Kairos Manado
- Laravel Community
- Fonnte Team
- Tailwind CSS Team

---

**Made with ❤️ for GSJA Kairos Manado**
