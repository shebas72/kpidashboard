<?php
/**
 * Test script to verify KPI Management System setup
 */

echo "=== KPI Management System - Setup Test ===\n\n";

// Test 1: Check if Laravel is working
echo "1. Testing Laravel framework...\n";
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel framework loaded successfully\n";
} catch (Exception $e) {
    echo "❌ Laravel framework failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: Check database connection
echo "\n2. Testing database connection...\n";
try {
    $config = $app['config']['database.connections.mysql'];
    $pdo = new PDO(
        "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}", 
        $config['username'], 
        $config['password']
    );
    echo "✅ Database connection successful\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check your .env file and MySQL configuration\n";
}

// Test 3: Check if tables exist
echo "\n3. Testing database tables...\n";
try {
    $tables = ['users', 'kpi_categories', 'kpis', 'kpi_data'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Table '$table' exists\n";
        } else {
            echo "❌ Table '$table' missing\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Table check failed: " . $e->getMessage() . "\n";
}

// Test 4: Check if test user exists
echo "\n4. Testing test user...\n";
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE email = 'test@example.com'");
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        echo "✅ Test user exists\n";
    } else {
        echo "❌ Test user missing\n";
    }
} catch (Exception $e) {
    echo "❌ User check failed: " . $e->getMessage() . "\n";
}

// Test 5: Check if categories exist
echo "\n5. Testing KPI categories...\n";
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM kpi_categories");
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        echo "✅ KPI categories exist ($count categories)\n";
    } else {
        echo "❌ No KPI categories found\n";
    }
} catch (Exception $e) {
    echo "❌ Category check failed: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "If all tests passed, you can start the server with: php artisan serve\n";
echo "Then visit: http://localhost:8000\n";
echo "Login with: test@example.com / password\n";
