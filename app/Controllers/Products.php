<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Model\Products_model;
use CodeIgniter\Files\File;
use Exception;


class Products extends BaseController
{
    public $request="";

    public function __construct()
    {
        $this->request=service('request');

    }

    public function index()
    {
        return view('pro_ducts');
    }
    public function add()
    {
        
        try
        {
            $modelUser = new \App\Models\Products_model();

            if($this->request->getMethod()=='post'){
            $product_name=$this->request->getPost('product_name');
            $product_price=$this->request->getPost('product_price');
            $images_base64=$this->request->getPost('images_base64');
            $product_description=$this->request->getPost('product_description');
            $pre_images=$this->request->getPost('image_url');
            $file_path=$pre_images;
            if( isset($pre_images) && count($pre_images)==0)
            {
                $this->check_blank('Product Images',$images_base64);
               
            }
            if( $images_base64!='')
            {
                $files = $images_base64;
                foreach($files as $img)
                {
                  $file_path[]=$this-> bas64saveimage($img);
                }

            }
           
           
           
            $this->check_blank('Product Description',trim($product_description));
            $this->check_blank('Product Price',trim($product_price));

           
            $this->check_blank('Product Name',trim($product_name));
            $modelUser->product_id=$this->request->getPost('product_id');

            $modelUser->product_name=$this->request->getPost('product_name');
            $modelUser->product_price=$this->request->getPost('product_price');

            $modelUser->product_description=$this->request->getPost('product_description');

            
            $modelUser->product_images=json_encode($file_path);
            $modelUser->add();
            $data['success']=true;
            $data['message']='Product Added Successfully!';

        }

    }
    catch(Exception $e)
    {
        $data['success']=false;
        $data['message']=$e->getMessage();
        $data['line']=$e->getLine();


    }
    if(isset($data))
    {
        return json_encode($data);
    }else{

        return view('add');
        
    }
   

}
public function get()
{
    $modelProduct = new \App\Models\Products_model();
   return  json_encode($modelProduct->get());

}
public function deletebyid()
{
    try{
        $modelProduct = new \App\Models\Products_model();
        $modelProduct->product_id=$this->request->getPost('id');
        $modelProduct->deletebyid();
        $data['success']=true;
        $data['message']='Product Deleted Successfully!';
        

    }catch(Exception $e)
    {
        $data['success']=false;
        $data['message']=$e->getMessage();
        $data['line']=$e->getLine();


    }
    return json_encode($data);
   


}
protected function check_blank($key='',$value)
{

    if(!($value))
    {
        throw new Exception("Missing ".$key);
    }


}
protected function bas64saveimage($dataurl)
{
    $explode=explode(';base64,',$dataurl);
    $image_ext=explode('data:image/', $explode[0])[1];
    $base64Image=$explode[1];
    if(!in_array( $image_ext,['png', 'gif', 'jpeg','jpg']))
    {
        throw new Exception("One or more invalid images !".$image_type);
    }

    $file_folder = WRITEPATH ."product_images/";
if(!file_exists( $file_folder))
{
    mkdir( $file_folder, 777);

}
   
    $file_name=time().rand(100000,9999999).uniqid().'.'.$image_ext; 
    $file_path=$file_folder.$file_name;
    file_put_contents($file_path, base64_decode($base64Image));
    return $file_name;
}

}
