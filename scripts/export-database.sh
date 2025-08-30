#!/bin/bash

# Database Export Script for GSJA Kairos Event Management
# Usage: ./scripts/export-database.sh

echo "🗄️ Exporting database for deployment..."

# Check if we're in Laravel project
if [ ! -f "artisan" ]; then
    echo "❌ Error: This script must be run from Laravel project root"
    exit 1
fi

# Export database using Laravel
echo "📤 Exporting database using Laravel..."
php artisan db:export --file=database_backup.sql

if [ $? -eq 0 ]; then
    echo "✅ Database exported successfully to: database_backup.sql"
    echo "📊 File size: $(du -h database_backup.sql | cut -f1)"
    echo ""
    echo "📋 Next steps:"
    echo "1. Upload database_backup.sql to Hostinger via phpMyAdmin"
    echo "2. Create subdomain: event.kairosmanado.id"
    echo "3. Push changes to GitHub to trigger deployment"
else
    echo "❌ Database export failed!"
    echo "💡 Alternative: Use phpMyAdmin to export database manually"
    exit 1
fi
