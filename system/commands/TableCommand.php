<?php
namespace System\Commands;

class TableCommand {

    protected $db;

    public function __construct($dbConnection) {
        // Nhận kết nối cơ sở dữ liệu từ ngoài
        $this->db = $dbConnection;
    }

    /**
     * Chạy Artisan Command để đồng bộ hóa schema
     */
    public function handle($tableName) {
        $modelClass = "\\App\\Models\\".ucfirst($tableName).'Model';
        // Khởi tạo model
        $model = new $modelClass();
        $table = $model->_table();
        $schema = $model->_schema();
        // Kiểm tra bảng và đồng bộ hóa cấu trúc
        $this->syncTableSchema($table, $schema);

        echo "Đã đồng bộ hóa bảng {$table}\n";
    }

    /**
     * Đồng bộ hóa cấu trúc bảng với schema
     */
    protected function syncTableSchema($table, $schema) {
        if (!$this->tableExists($table)) {
            $this->createTable($table, $schema);
        } else {
            $this->updateTable($table, $schema);
        }
    }

    /**
     * Kiểm tra bảng có tồn tại hay không
     */
    protected function tableExists($table) {
        $query = "SHOW TABLES LIKE '{$table}'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Tạo bảng mới từ schema
     */
    protected function createTable($table, $schema) {
        $columns = [];

        foreach ($schema as $column => $attributes) {
            $columns[] = $this->buildColumnTable($column, $attributes);
        }

        $query = "CREATE TABLE {$table} (" . implode(', ', $columns) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        echo $query;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        echo "Đã tạo bảng {$table}\n";
    }

    /**
     * Cập nhật bảng hiện tại với schema mới
     */
    protected function updateTable($table, $schema) {
        // Lấy danh sách cột hiện tại trong bảng
        $currentColumns = $this->getCurrentColumns($table);
        $dbColumns = [];
        if ($currentColumns && count($currentColumns) > 0){
            foreach ($currentColumns as $dbField){
                $dbColumns[$dbField["Field"]] = $dbField;
            }
        }
        print_r($dbColumns);
        foreach ($schema as $column => $attributes) {
            if (!array_key_exists($column, $dbColumns)) {
                // Cột không tồn tại, thêm mới
                $this->addColumn($table, $column, $attributes);
            } else {
                // Cột tồn tại, kiểm tra và cập nhật nếu cần
                print_r($dbColumns[$column]);
                print_r($attributes);
                if ($this->needsModification($column, $dbColumns[$column], $attributes)) {
                    $this->modifyColumn($table, $column, $attributes);
                }
            }
        }
    }

    
    protected function buildColumnTable($column, $attributes) {
        $definition = "{$column} {$attributes['type']}";

        if (isset($attributes['null']) && !$attributes['null']) {
            $definition .= " NOT NULL";
        }

        if (isset($attributes['auto_increment']) && $attributes['auto_increment'] === true) {
            $definition .= " AUTO_INCREMENT";
        }

        if (isset($attributes['key'])) {
            if ($attributes['key'] == 'primary'){
                $definition .= " PRIMARY KEY";
            }else if ($attributes['key'] == 'unique'){
                $definition .= " UNIQUE";
            }
        }

        if (isset($attributes['default'])) {
            $definition .= " DEFAULT '{$attributes['default']}'";
        }

        if (isset($attributes['on_update'])) {
            $definition .= " ON UPDATE " . $attributes['on_update'];
        }

        return $definition;
    }

    /**
     * Xây dựng định nghĩa cột từ schema
     */
    protected function buildColumnUpdate($column, $attributes) {
        $definition = "{$column} {$attributes['type']}";

        if (isset($attributes['null'])) {
            if (!$attributes['null']){
                $definition .= " NOT NULL";
            }else{
                $definition .= " NULL";
            }
        }

        
        if (isset($attributes['default'])) {
            $definition .= " DEFAULT '{$attributes['default']}'";
        }

        if (isset($attributes['on_update'])) {
            $definition .= " ON UPDATE " . $attributes['on_update'];
        }

        if (isset($attributes['auto_increment']) && $attributes['auto_increment'] === true) {
            $definition .= " AUTO_INCREMENT, add PRIMARY KEY (`$column`)";
        }else{
            if (isset($attributes['key'])) {
                if ($attributes['key'] == 'primary'){
                    $definition .= " PRIMARY KEY";
                }else if ($attributes['key'] == 'unique'){
                    $definition .= " , ADD UNIQUE (`$column`) ";
                }else if ($attributes['key'] == 'index'){
                    $definition .= " , ADD INDEX (`$column`) ";
                }
            }
        }


        return $definition;
    }

    /**
     * Kiểm tra nếu cần cập nhật cột
     */
    protected function needsModification($column, $currentColumn, $newAttributes) {
        // So sánh thuộc tính Type
        if (strtolower($currentColumn['Type']) !== strtolower($newAttributes['type'])){
            echo $column . ' change TYPE tu '.$currentColumn['Type'].' sang '.$newAttributes['type'];
            return true;
        }
        // So sánh thuộc tính Null
        $currentNull = strtolower($currentColumn['Null']) === 'yes' ? true : false;
        $newNull = isset($newAttributes['null']) && $newAttributes['null'] ? true : !empty($newAttributes['null']);
        if ($currentNull !== $newNull) {
            echo $column . ' change Null tu '.(int)$currentNull.' sang '.(int)$newNull;
            return true;
        }
        // So sánh thuộc tính Key (Primary, Unique)
        $currentKey = strtolower($currentColumn['Key']);
        switch ($currentKey){
            case 'mul':
                $currentKey = 'index';
            break;
            case 'uni':
                $currentKey = 'unique';
            break;
            case 'pri':
                $currentKey = 'primary';
            break;
            default:
                $currentKey = '';
            break;
        }
        $newKey = isset($newAttributes['key']) ? strtolower($newAttributes['key']) : '';
        if ($currentKey !== $newKey) {
            echo $column . ' change Key tu '.$currentKey.' sang '.$newKey;
            return true;
        }

        // So sánh giá trị mặc định (Default)
        $currentDefault = $currentColumn['Default'] ?? '';
        $newDefault = $newAttributes['default'] ?? '';
        if ($currentDefault != $newDefault) {
            echo $column . ' change ValueDefault tu '.$currentDefault.' sang '.$newDefault;
            return true;
        }

        // So sánh thuộc tính Extra (auto_increment)
        $currentExtra = strpos(strtolower($currentColumn['Extra']), 'auto_increment') !== FALSE ? true : false;
        $newExtra = isset($newAttributes['auto_increment']) && $newAttributes['auto_increment'] ? true : false;
        if ($currentExtra !== $newExtra) {
            echo $column . ' change auto_increment tu '.(int)$currentExtra.' sang '.(int)$newExtra;
            return true;
        }

        return false;
    }

    /**
     * Lấy danh sách cột hiện tại
     */
    protected function getCurrentColumns($table) {
        $query = "SHOW COLUMNS FROM {$table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Thêm cột mới vào bảng
     */
    protected function addColumn($table, $column, $attributes) {
        $query = "ALTER TABLE {$table} ADD " . $this->buildColumnUpdate($column, $attributes);
        echo $query;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        echo "Đã thêm cột {$column} vào bảng {$table}\n";
    }

    /**
     * Cập nhật cột hiện tại
     */
    protected function modifyColumn($table, $column, $attributes) {
        $query = "ALTER TABLE {$table} MODIFY " . $this->buildColumnUpdate($column, $attributes);
        echo $query;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        echo "Đã cập nhật cột {$column} trong bảng {$table}\n";
    }
}