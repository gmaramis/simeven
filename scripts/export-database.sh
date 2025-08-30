#!/bin/bash

# Database Export Script for GSJA Kairos Event Management
# Usage: ./scripts/export-database.sh

echo "🗄️ Exporting database for deployment..."

# Database configuration
DB_NAME="event-kairos"
DB_USER="root"
DB_PASSWORD=""
OUTPUT_FILE="database_backup.sql"

# Export database
echo "📤 Exporting database: $DB_NAME"
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME > $OUTPUT_FILE

if [ $? -eq 0 ]; then
    echo "✅ Database exported successfully to: $OUTPUT_FILE"
    echo "📊 File size: $(du -h $OUTPUT_FILE | cut -f1)"
    echo ""
    echo "📋 Next steps:"
    echo "1. Upload $OUTPUT_FILE to Hostinger"
    echo "2. Import database using phpMyAdmin or command line"
    echo "3. Update .env file with production database credentials"
else
    echo "❌ Database export failed!"
    exit 1
fi
