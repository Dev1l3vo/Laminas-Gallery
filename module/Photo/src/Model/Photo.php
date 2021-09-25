<?php 
namespace Photo\Model;


class Photo 
{
    public $id;
    public $encode_photo;
    public $name;
    

    
   

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->encode_photo = !empty($data['encode_photo']) ? $data['encode_photo'] : null;
        $this->name  = !empty($data['name']) ? $data['name'] : null;
    }
}