<?php
// Clear Laravel Cache
// Upload file ini ke root folder hosting

echo "<h2>🧹 Clearing Laravel Cache</h2>";

// Load Laravel
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;

try {
    // Clear all caches
    Artisan::call('config:clear');
    echo "✅ Config cache cleared<br>";
    
    Artisan::call('cache:clear');
    echo "✅ Application cache cleared<br>";
    
    Artisan::call('route:clear');
    echo "✅ Route cache cleared<br>";
    
    Artisan::call('view:clear');
    echo "✅ View cache cleared<br>";
    
    // Regenerate caches
    Artisan::call('config:cache');
    echo "✅ Config cache regenerated<br>";
    
    Artisan::call('route:cache');
    echo "✅ Route cache regenerated<br>";
    
    Artisan::call('view:cache');
    echo "✅ View cache regenerated<br>";
    
    echo "<br>🎉 All caches cleared and regenerated successfully!";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
