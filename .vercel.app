{
    "functions": {
        "api/index.php": {
            "runtime": "vercel-php@0.6.0"
        }
    },
    "routes": [
        { "src": "/(css|js|images|build)/(.*)", "dest": "/public/$1/$2" },
        { "src": "/(.*)", "dest": "/api/index.php" }
    ],
    "build": {
        "env": {
            "NOW_PHP_DEBUG": "1"
        }
    }
}