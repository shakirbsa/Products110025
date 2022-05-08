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
        if($this->product_id>0)
        {
            $this->deletebyid();
        }
        $data = [
            'product_name' => $this->product_name,
            'product_price'  => $this->product_price,
            'product_description'  =>  $this->product_description,
            'product_image'  =>  $this->product_images,
        ];
        
       return $this->builder->insert($data);

    }
    function get($id=0){
        $where = [
            'is_active' => '1',
           
        ];
        if($id>0)
        {
            $where['id']=$id;
        }
        $this->builder->select();
        $query=$this->builder->getWhere($where);
      $data=[];
      if( true)
      {

    
      foreach ($query->getResult() as $row) {
        $Innerdata=[];
        $Innerdata[]=$row->id;
        $Innerdata[]=$row->product_name;
        $Innerdata[]=$row->product_price;
        $Innerdata[]=$row->product_description;
       
        $images=json_decode($row->product_image);
        $img_text='';
        $img_chekbox='';
        $i=0;
        if($images)
        {
            foreach($images as $img_url)
            {
                $i++;
                $img_text1='<a href="../writable/product_images\/'. $img_url.'"  target="_blank" ><img src="../writable/product_images\/'. $img_url.'"  height="100px"/></a>';
                $img_text.=$img_text1;
                $img_chekbox.='<span class="edtimg"><label for ="img'.$i.'"><input type="checkbox" id="img'.$i.'" name="image_url[]" value="'.$img_url.'" checked>'.$img_text1.'</span>';
    
            }

        }
       
        $Innerdata[]=$img_text;
        $Innerdata[]='
    <a href="#" class="btn btn-primary a-btn-slide-text  edit" data-id="'.$row->id.'" data-name="'.$row->product_name.'" data-price="'.$row->product_price.'" data-description="'.$row->product_description.'" data-images="'. base64_encode($img_chekbox).'">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        <span><strong>Edit</strong></span>            
    </a>
    <a href="#" class="btn btn-danger a-btn-slide-text delete"  data-id="'.$row->id.'">
        <span class="glyphicon glyphicon-eye-open "  aria-hidden="true"></span>
        <span><strong>Delete</strong></span>            
    </a>';
        $data[]=$Innerdata;
    }
}
    return $data;

    }
    function deletebyid()
    {

       $this->builder->set('is_active', '0');
       $this->builder->where('id', $this->product_id);
       $this->builder->update();

    }
}
