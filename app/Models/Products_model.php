<?php

namespace App\Models;

use CodeIgniter\Model;

class Products_model extends Model
{
    
    public $product_id=0;
    public $product_name=0;
    public $product_description=0;
    public $product_images="";
    public $product_price=0;
    public $builder;

    protected $DBGroup          = 'default';
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    function __construct()
    {
        $db      = \Config\Database::connect();
$this->builder = $db->table($this->table);
    }
    function add(){
        $data = [
            'product_name' => $this->product_name,
            'product_price'  => $this->product_price,
            'product_description'  =>  $this->product_description,
            'product_image'  =>  $this->product_images,
        ];
        
       return $this->builder->insert($data);

    }
}
