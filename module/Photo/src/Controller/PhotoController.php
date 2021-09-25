<?php 
namespace Photo\Controller;

use Photo\Model\PhotoTable;
use Photo\Model\Photo;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Photo\Form;
use Laminas\Http\Response;
use Laminas\Http\Cookies;

class PhotoController extends AbstractActionController
{
    private $table;

    
    public function __construct(PhotoTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $img = $this->table->getPhoto(1);
        return new ViewModel([
            'picture' => $img,
        ]);
    }

    public function addAction()
    {
        $form = new Form\PhotoForm();  
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $photo = new Photo();
        $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );
        

        $form->setData($post);

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $data = $form->getData();
        $data = array("name"=>$data["file"]["name"],"encode_photo"=>base64_encode(file_get_contents($data["file"]["tmp_name"])) );
        $photo->exchangeArray($data);
        $this->table->savePhoto($photo);
        return $this->redirect()->toRoute('photo',['action' => 'index']);
    }


    public function nextAction(){
        return $this->prevNextAction(false);
    }

    public function prevAction(){
        return $this->prevNextAction(true);
    }

    private function prevNextAction($prev){
        $request = $this->getRequest();
        $id = intval($this->params()->fromRoute('id'));
        $response = new Response();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders([
            'Content-Type'=> 'application/json'
        ]);
        if($request->isGet() && $id){
            $img = $this->table->getPhoto($id,$prev);
            if($img){
                $response->setContent(json_encode($img));
            }else{
                $response->setContent(json_encode(array('error'=>"End of Gallery")));
            }
            return  $response;
        }
        $response->setContent(json_encode(array('error'=>"Problem with image id")));
        return  $response;
    }

    public function deleteAction()
    {   
        $id = intval($this->params()->fromRoute('id'));
        $response = new Response();
        $response->setStatusCode(Response::STATUS_CODE_200);
        $response->getHeaders()->addHeaders([
            'Content-Type'=> 'application/json'
        ]);
       
    
        if ($this->getRequest()->isGet() && $this->table->existPhoto()){
            $this->table->deletePhoto($id);
        }
        $this->redirect()->toRoute('photo',['action' => 'index']);
    }
}