<?php
// Test Authentication Configuration
// Upload file ini ke root folder hosting

// Load Laravel
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "<h2>🔍 Laravel Authentication Test</h2>";

// Test 1: Database Connection
echo "<h3>1. Database Connection Test</h3>";
try {
    $users = DB::table('users')->get();
    echo "✅ Database connected successfully<br>";
    echo "📊 Total users: " . $users->count() . "<br>";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test 2: Hash Test
echo "<h3>2. Password Hash Test</h3>";
$password = 'password';
$hash = Hash::make($password);
echo "Password: $password<br>";
echo "Generated Hash: $hash<br>";
echo "Hash Length: " . strlen($hash) . " characters<br>";
echo "Check Result: " . (Hash::check($password, $hash) ? '✅ TRUE' : '❌ FALSE') . "<br>";

// Test 3: User Data
echo "<h3>3. User Data Test</h3>";
try {
    $adminUser = DB::table('users')->where('email', 'admin@kairosmanado.id')->first();
    if ($adminUser) {
        echo "✅ User found: {$adminUser->email}<br>";
        echo "Password Hash: {$adminUser->password}<br>";
        echo "Hash Length: " . strlen($adminUser->password) . " characters<br>";
        echo "Check with 'password': " . (Hash::check('password', $adminUser->password) ? '✅ TRUE' : '❌ FALSE') . "<br>";
    } else {
        echo "❌ User not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 4: Environment
echo "<h3>4. Environment Test</h3>";
echo "APP_ENV: " . env('APP_ENV', 'not set') . "<br>";
echo "APP_DEBUG: " . env('APP_DEBUG', 'not set') . "<br>";
echo "DB_CONNECTION: " . env('DB_CONNECTION', 'not set') . "<br>";
echo "DB_HOST: " . env('DB_HOST', 'not set') . "<br>";
echo "DB_DATABASE: " . env('DB_DATABASE', 'not set') . "<br>";

// Test 5: Create Test User
echo "<h3>5. Create Test User</h3>";
try {
    $testHash = Hash::make('test123');
    DB::table('users')->insert([
        'name' => 'Test User',
        'email' => 'test@kairosmanado.id',
        'email_verified_at' => now(),
        'password' => $testHash,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "✅ Test user created successfully<br>";
    echo "Email: test@kairosmanado.id<br>";
    echo "Password: test123<br>";
} catch (Exception $e) {
    echo "❌ Error creating test user: " . $e->getMessage() . "<br>";
}
?>
