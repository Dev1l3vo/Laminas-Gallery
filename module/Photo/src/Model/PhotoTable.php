<?php 
namespace Photo\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGateway ;
use Laminas\Db\TableGateway\ResultSetInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;

class PhotoTable
{
    private $tableGateway;

    public function __construct(TableGateway  $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
        
    public function getPhoto($id,$prev=false){
        $select = $this->tableGateway->getSql()->select();
        $predicate  = new Where();
        if($prev){
            $select->where($predicate->lessThanOrEqualTo('id',$id));
        }else{
            $select->where($predicate->greaterThanOrEqualTo('id',$id));
        }
        $select->limit(1);
        $result = $this->tableGateway->selectWith($select);
        return $result->current();
    }

    public function existPhoto(){
        return $this->tableGateway->select()->current() != NULL;
    }

    public function savePhoto(Photo $photo)
    {
        $data = [
            'encode_photo' => $photo->encode_photo,
            'name'  => $photo->name,
        ];

        $id = (int) $photo->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
    }

    public function deletePhoto($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}