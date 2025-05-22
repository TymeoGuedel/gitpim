<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Récupère la propriété protégée $routeMiddleware via réflexion
$reflection = new ReflectionClass($kernel);
$property = $reflection->getProperty('routeMiddleware');
$property->setAccessible(true);

$routeMiddleware = $property->getValue($kernel);

// Vérifie si "admin" est bien défini
if (isset($routeMiddleware['admin'])) {
    echo "✅ Le middleware 'admin' est bien enregistré.\n";
    echo "➡ Classe cible : " . $routeMiddleware['admin'] . "\n";

    if ($routeMiddleware['admin'] === \App\Http\Middleware\IsAdmin::class) {
        echo "🎯 Et c'est bien la classe attendue.\n";
    } else {
        echo "⚠ Attention : ce n'est pas la classe attendue.\n";
    }

} else {
    echo "❌ Le middleware 'admin' n'est pas défini dans Kernel.php.\n";
}
