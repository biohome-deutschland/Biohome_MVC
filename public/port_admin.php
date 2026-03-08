<?php
$files = ['products', 'pages', 'categories', 'filters', 'filter_types', 'filter_brands', 'settings', 'menus', 'slider', 'media'];

foreach ($files as $name) {
    $srcPath = '/app/Biohome_CMS/admin/' . $name . '.php';
    if (!file_exists($srcPath)) {
        echo "Skip $name\n";
        continue;
    }

    $srcContent = file_get_contents($srcPath);
    $parts = explode('<!DOCTYPE html>', $srcContent);
    if (count($parts) < 2) continue; // not a standard file

    $phpPart = $parts[0];
    $htmlPart = '<!DOCTYPE html>' . $parts[1];

    $uiParts = explode('<main class="main">', $htmlPart);
    if (count($uiParts) < 2) continue;
    
    $uiContent = $uiParts[1];
    $uiContent = str_replace('</main>', '', $uiContent);
    // remove body script or html tags at the end
    $uiContent = preg_replace('/<\/body>\s*<\/html>/i', '', $uiContent);
    // rename links in UI
    $uiContent = preg_replace('/href="([a-z_]+)\.php(.*?)"/i', 'href="/admin/$1$2"', $uiContent);
    // Fix action=...
    $uiContent = str_replace('action="/admin/', 'action="/admin/', $uiContent);

    // Clean PHP part
    $phpPart = preg_replace('/<\?php\s+declare\(strict_types=1\);\s+require.*?;/is', '', $phpPart);
    $phpPart = preg_replace('/require_admin\(\);/i', '', $phpPart);
    $phpPart = preg_replace('/require_once .*?;/i', '', $phpPart);
    $phpPart = preg_replace('/\$admin_page = .*?;/i', '', $phpPart);
    
    // Convert to MVC db
    $phpPart = str_replace('$pdo', '$db', $phpPart);
    
    // Redirects
    $phpPart = preg_replace('/header\(\'Location: ([a-z_]+)\.php(.*?)\'\)/i', 'header(\'Location: /admin/$1$2\')', $phpPart);

    $pascalName = str_replace('_', '', ucwords($name, '_'));

    $controllerCode = "<?php\n\nnamespace App\Controllers;\n\nuse Core\Controller;\nuse Core\View;\nuse PDO;\nuse PDOException;\n\n";
    $controllerCode .= "class Admin{$pascalName}Controller extends Controller\n{\n";
    $controllerCode .= "    protected function before()\n    {\n        if (empty(\$_SESSION['admin_logged_in']) || \$_SESSION['admin_logged_in'] !== true) {\n            header('Location: /admin/login');\n            exit;\n        }\n    }\n\n";
    $controllerCode .= "    public function indexAction()\n    {\n        \$db = \Core\Model::getDB();\n";
    
    $controllerCode .= $phpPart;

    // The magic renderer
    $routeUrl = 'admin/' . str_replace('_', '-', $name);
    $controllerCode .= "\n        \$args = get_defined_vars();\n";
    $controllerCode .= "        \$args['content_view'] = 'Admin/{$name}.php';\n";
    $controllerCode .= "        \$args['admin_page'] = '{$routeUrl}';\n";
    $controllerCode .= "        View::renderTemplate('Admin/Layouts/main.php', \$args);\n";
    $controllerCode .= "    }\n}\n";

    file_put_contents('/app/Biohome_New_App/app/Controllers/Admin' . $pascalName . 'Controller.php', $controllerCode);
    file_put_contents('/app/Biohome_New_App/app/Views/Admin/' . $name . '.php', trim($uiContent));
    
    echo "Ported $name\n";
}
