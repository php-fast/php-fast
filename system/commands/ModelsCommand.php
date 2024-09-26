<?php
namespace System\Commands;

class ModelsCommand {
    /**
     * Create a new model file
     */
    public function create($modelName) {
        // Define the path for the new model
        $modelPath = ROOT_PATH . '/application/models/' . ucfirst($modelName) . 'Model.php';
        
        // Check if the model already exists
        if (file_exists($modelPath)) {
            echo "Model {$modelName} already exists.\n";
            return;
        }

        // Define the contents of the model
        $modelContent = <<<PHP
<?php
namespace App\Models;
use System\Core\BaseModel;

class {$modelName}Model extends BaseModel {

    protected \$table = '{$modelName}';

    // Columns that are fillable (can be added or modified)
    protected \$fillable = ['name'];

    // Columns that are guarded (cannot be modified)
    protected \$guarded = ['id', 'created_at'];

    /**
     * Define the table schema
     * 
     * @return array Table schema
     */
    public function _schema() {
        return [
            'id' => [
                'type' => 'int unsigned',
                'auto_increment' => true,
                'key' => 'primary',
                'null' => false
            ],
            'name' => [
                'type' => 'varchar(150)',
                'null' => false,
                'default' => ''
            ]
        ];
    }

    /**
     * Get all records
     */
    public function get{$modelName}s(\$where = '', \$params = [], \$orderBy = 'id DESC', \$limit = null, \$offset = null) {
        return \$this->list(\$this->table, \$where, \$params, \$orderBy, \$limit, \$offset);
    }

    /**
     * Add a new record
     */
    public function add{$modelName}(\$data) {
        \$data = \$this->fill(\$data);
        return \$this->add(\$this->table, \$data);
    }

    /**
     * Update an existing record
     */
    public function set{$modelName}(\$id, \$data) {
        \$data = \$this->fill(\$data);
        return \$this->set(\$this->table, \$data, 'id = ?', [\$id]);
    }

    /**
     * Delete a record
     */
    public function del{$modelName}(\$id) {
        return \$this->del(\$this->table, 'id = ?', [\$id]);
    }
}
PHP;

        // Create the model file
        file_put_contents($modelPath, $modelContent);

        echo "Model {$modelName}Model has been created successfully.\n";
    }
}
