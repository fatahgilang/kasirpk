<?php
require_once 'vendor/autoload.php';

use App\Models\Transaction;

// Test if Transaction model works
try {
    $transaction = new Transaction();
    echo "Transaction model created successfully\n";
    
    // Check if it has ID property (inherited from Eloquent Model)
    $reflection = new ReflectionClass($transaction);
    $properties = $reflection->getProperties();
    
    $hasId = false;
    foreach ($properties as $prop) {
        if ($prop->getName() === 'id') {
            $hasId = true;
            break;
        }
    }
    
    echo "Has ID property: " . ($hasId ? 'Yes' : 'No') . "\n";
    
    // Check if it's accessible
    echo "ID accessible: " . (isset($transaction->id) ? 'Yes' : 'No') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}