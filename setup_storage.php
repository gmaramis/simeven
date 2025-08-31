<?php
// Setup Storage Link for Hosting
// Upload file ini ke root folder hosting dan akses via browser

echo "<h2>🔗 Setup Storage Link</h2>";

// Load Laravel
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;

try {
    echo "<h3>1. Checking Current Setup</h3>";
    
    $storagePath = storage_path('app/public');
    $publicStoragePath = public_path('storage');
    
    echo "Storage path: $storagePath<br>";
    echo "Public storage path: $publicStoragePath<br>";
    echo "Storage exists: " . (file_exists($storagePath) ? '✅ YES' : '❌ NO') . "<br>";
    echo "Public storage exists: " . (file_exists($publicStoragePath) ? '✅ YES' : '❌ NO') . "<br>";
    
    echo "<h3>2. Creating Storage Directories</h3>";
    
    // Create storage directories
    $directories = [
        'app/public',
        'app/public/events',
        'app/public/uploads',
        'app/public/images'
    ];
    
    foreach ($directories as $dir) {
        $fullPath = storage_path($dir);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
            echo "✅ Created: $dir<br>";
        } else {
            echo "✅ Exists: $dir<br>";
        }
    }
    
    echo "<h3>3. Creating Storage Link</h3>";
    
    // Remove existing symlink if exists
    if (is_link($publicStoragePath)) {
        unlink($publicStoragePath);
        echo "✅ Removed existing symlink<br>";
    }
    
    // Create storage link
    Artisan::call('storage:link');
    echo "✅ Storage link created<br>";
    
    echo "<h3>4. Setting Permissions</h3>";
    
    // Set permissions
    $paths = [
        storage_path(),
        storage_path('app'),
        storage_path('app/public'),
        storage_path('app/public/events'),
        public_path('storage')
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            chmod($path, 0755);
            echo "✅ Set permissions: $path<br>";
        }
    }
    
    echo "<h3>5. Testing Storage Link</h3>";
    
    // Test if symlink works
    if (is_link($publicStoragePath)) {
        $target = readlink($publicStoragePath);
        echo "✅ Symlink created successfully<br>";
        echo "Target: $target<br>";
        
        // Test file access
        $testFile = $publicStoragePath . '/test.txt';
        file_put_contents($testFile, 'Test file for storage link');
        echo "✅ Test file created: $testFile<br>";
        
        // Clean up test file
        unlink($testFile);
        echo "✅ Test file cleaned up<br>";
    } else {
        echo "❌ Symlink creation failed<br>";
    }
    
    echo "<h3>6. Clear Cache</h3>";
    
    // Clear caches
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    echo "✅ All caches cleared<br>";
    
    echo "<br>🎉 Storage setup completed!";
    echo "<br><br>📋 Next steps:";
    echo "<br>1. Upload images via admin panel";
    echo "<br>2. Test image display on frontend";
    echo "<br>3. Delete this file for security";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
    echo "<br><br>💡 Try manual setup:";
    echo "<br>1. Create folder 'storage' in public directory";
    echo "<br>2. Copy files from storage/app/public/ to public/storage/";
}
?>
