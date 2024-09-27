<?php
namespace App\Models;
use System\Core\BaseModel;

class MoviesModel extends BaseModel {

    protected $table = 'Movies';

    // Columns that are fillable (can be added or modified)
    protected $fillable = ['name'];

    // Columns that are guarded (cannot be modified)
    protected $guarded = ['id', 'created_at'];

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
    public function getMoviess($where = '', $params = [], $orderBy = 'id DESC', $limit = null, $offset = null) {
        return $this->list($this->table, $where, $params, $orderBy, $limit, $offset);
    }

    /**
     * Add a new record
     */
    public function addMovies($data) {
        $data = $this->fill($data);
        return $this->add($this->table, $data);
    }

    /**
     * Update an existing record
     */
    public function setMovies($id, $data) {
        $data = $this->fill($data);
        return $this->set($this->table, $data, 'id = ?', [$id]);
    }

    /**
     * Delete a record
     */
    public function delMovies($id) {
        return $this->del($this->table, 'id = ?', [$id]);
    }
}