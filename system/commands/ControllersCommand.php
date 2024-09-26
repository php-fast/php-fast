<?php
namespace System\Commands;

class ControllersCommand {

    /**
     * Create a new controller file
     */
    public function create($name) {
        $controllerPath = ROOT_PATH . '/application/controllers/' . ucfirst($name) . 'Controller.php';

        // Check if controller already exists
        if (file_exists($controllerPath)) {
            echo "Controller $name already exists.\n";
            return;
        }

        // Basic controller template
        $controllerContent = "<?php\n";
        $controllerContent .= "namespace App\Controllers;\n\n";
        $controllerContent .= "use System\Core\BaseController;\n\n";
        $controllerContent .= "class " . ucfirst($name) . "Controller extends BaseController {\n\n";
        $controllerContent .= "    public function index() {\n";
        $controllerContent .= "        echo 'Hello from " . ucfirst($name) . "Controller!';\n";
        $controllerContent .= "    }\n";
        $controllerContent .= "}\n";

        // Write the controller file
        file_put_contents($controllerPath, $controllerContent);
        echo "Controller $name created at $controllerPath.\n";

        // Prompt for model creation
        echo "Do you want to create a model for $name? (y/n): ";
        $response = trim(fgets(STDIN));
        if (strtolower($response) == 'y') {
            $modelCommand = new ModelsCommand();
            $modelCommand->create($name);
        }
    }
}
