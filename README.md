# 🎯 Event Management System - GSJA Kairos Manado

**Last Updated:** 2025-08-30 11:30 WIB

A comprehensive event management system designed specifically for GSJA Kairos Manado church to manage events, registrations, and participant communications.

## ✨ Features

### 🎪 Event Management
- **Create & Manage Events** - Full CRUD operations for events
- **Event Publishing** - Control event visibility (draft/published)
- **Image Upload** - Support for event banners and images
- **Seat Management** - Track available seats and registrations
- **Event Details** - Rich event information (date, time, location, description)

### 📝 Registration System
- **Public Registration** - User-friendly registration forms
- **Admin Registration** - Manual registration by administrators
- **Duplicate Prevention** - Prevent duplicate registrations
- **Status Management** - Track registration status (pending/confirmed/cancelled)
- **Bulk Operations** - Select and delete multiple registrations
- **Individual Deletion** - Remove specific registrations

### 📱 WhatsApp Integration
- **Fonnte API Integration** - Automated WhatsApp messaging
- **Confirmation Messages** - Auto-send registration confirmations
- **Reminder System** - H-1 and H-0 event reminders
- **Message Tracking** - Monitor sent/failed messages
- **Quota Management** - Track WhatsApp API quota
- **Retry Mechanism** - Retry failed messages

### ✅ Check-in System
- **Real-time Check-in** - Mobile-friendly check-in interface
- **Search Participants** - Find participants by phone number
- **Check-in Tracking** - Record check-in time and admin
- **Event Statistics** - Real-time registration and check-in stats
- **Multiple Check-in Points** - Support for multiple stations

### 🎨 Modern UI/UX
- **Responsive Design** - Works on desktop, tablet, and mobile
- **Tailwind CSS** - Modern, clean design system
- **GSJA Kairos Branding** - Custom colors and branding
- **Smooth Animations** - Enhanced user experience
- **Dark/Light Mode Ready** - Flexible theming

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x (PHP 8.2+)
- **Frontend:** Tailwind CSS, Alpine.js
- **Database:** MySQL 8.0+
- **WhatsApp:** Fonnte API
- **Deployment:** GitHub Actions + Hostinger
- **Version Control:** Git

## 🚀 Installation

### Requirements
- PHP 8.2 or higher
- Composer
- Node.js 18+ and NPM
- MySQL 8.0 or higher
- Web server (Apache/Nginx)

### Step-by-Step Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/gmaramis/simeven.git
   cd simeven
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   ```bash
   # Update .env file with your database credentials
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=event-kairos
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Run database migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Create storage link**
   ```bash
   php artisan storage:link
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://127.0.0.1:8000`

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
# Clear all caches
php artisan optimize:clear

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link
```

## 📊 Database Structure

### Core Tables
- **events** - Event information and settings
- **registrations** - Participant registrations
- **users** - Admin users
- **whatsapp_messages** - WhatsApp message history

### Key Relationships
- Events have many Registrations
- Registrations belong to Events
- Registrations have many WhatsApp Messages

## 🔒 Security Features

- **CSRF Protection** - All forms protected
- **Input Validation** - Server-side validation
- **SQL Injection Prevention** - Eloquent ORM
- **XSS Protection** - Blade templating
- **File Upload Security** - Validated uploads
- **Environment Variables** - Sensitive data protection

## ⚡ Performance Optimization

- **Laravel Caching** - Config, route, and view caching
- **Asset Optimization** - Minified CSS/JS
- **Database Indexing** - Optimized queries
- **Image Optimization** - Compressed uploads
- **CDN Ready** - Static asset delivery

## 🆘 Troubleshooting

### Common Issues

#### WhatsApp Integration
- **Check Fonnte API token** - Verify in .env file
- **Test device connection** - Ensure WhatsApp is connected
- **Verify phone numbers** - Use correct format (08xxxxxxxxxx)

#### Database Issues
- **Check credentials** - Verify .env configuration
- **Run migrations** - `php artisan migrate`
- **Clear cache** - `php artisan config:clear`

#### Storage Issues
- **Create storage link** - `php artisan storage:link`
- **Check permissions** - Ensure write access
- **Verify disk space** - Check available storage

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support and questions:
- **Email:** gmaramis@kairosmanado.id
- **GitHub Issues:** [Create an issue](https://github.com/gmaramis/simeven/issues)

## 🙏 Acknowledgments

- **GSJA Kairos Manado** - For the opportunity to serve
- **Laravel Community** - For the amazing framework
- **Tailwind CSS** - For the beautiful design system
- **Fonnte** - For WhatsApp integration services
