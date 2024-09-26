<?php
namespace System\Framework;

class ModelsCommand {

    /**
     * Create a new model file
     */
    public function create($name) {
        $modelPath = ROOT_PATH . '/application/models/' . ucfirst($name) . 'Model.php';

        // Check if model already exists
        if (file_exists($modelPath)) {
            echo "Model $name already exists.\n";
            return;
        }

        // Basic model template
        $modelContent = "<?php\n";
        $modelContent .= "namespace App\Models;\n\n";
        $modelContent .= "use System\Core\BaseModel;\n\n";
        $modelContent .= "class " . ucfirst($name) . "Model extends BaseModel {\n\n";
        $modelContent .= "    protected \$table = '" . strtolower($name) . "';\n\n";
        $modelContent .= "    // Define schema for the model\n";
        $modelContent .= "    public function _schema() {\n";
        $modelContent .= "        return [\n";
        $modelContent .= "            'id' => [\n";
        $modelContent .= "                'type' => 'int unsigned',\n";
        $modelContent .= "                'auto_increment' => true,\n";
        $modelContent .= "                'key' => 'primary',\n";
        $modelContent .= "                'null' => false\n";
        $modelContent .= "            ],\n";
        $modelContent .= "            'name' => [\n";
        $modelContent .= "                'type' => 'varchar(255)',\n";
        $modelContent .= "                'null' => false,\n";
        $modelContent .= "                'default' => ''\n";
        $modelContent .= "            ]\n";
        $modelContent .= "        ];\n";
        $modelContent .= "    }\n\n";
        $modelContent .= "    // Additional methods for the model\n";
        $modelContent .= "    public function get" . ucfirst($name) . "s() {\n";
        $modelContent .= "        return \$this->list(\$this->table);\n";
        $modelContent .= "    }\n";
        $modelContent .= "    public function add" . ucfirst($name) . "(\$data) {\n";
        $modelContent .= "        return \$this->add(\$this->table, \$data);\n";
        $modelContent .= "    }\n";
        $modelContent .= "}\n";

        // Write the model file
        file_put_contents($modelPath, $modelContent);
        echo "Model $name created at $modelPath.\n";
    }
}
