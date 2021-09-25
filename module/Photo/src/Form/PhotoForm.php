<?php 
namespace Photo\Form;

use Laminas\Form\Form;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;


class PhotoForm extends Form
{
    public function __construct($name = null)
    {
       
        parent::__construct('photo-form');

        $this->setAttribute('method', 'post');
                
    
        $this->setAttribute('enctype', 'multipart/form-data');
				
        $this->add([//add elements to form
            'type'  => 'file',
            'name' => 'file',
            'attributes' => [                
                'id' => 'file'
            ],
            'options' => [
                'label' => 'Select image',
            ],
        ]);        
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Upload Img',
                'id'    => 'submit',
            ],
        ]);    
        
        $this->addPhotoFilter();
    }

    public function addPhotoFilter(){
       

        $inputFilter = new InputFilter\InputFilter();
        
       
        $fileInput = new InputFilter\FileInput('file');
        $fileInput->setRequired(true);

        $fileInput->getValidatorChain()
        ->attachByName('filesize',      ['max' => 2000000])
        ->attachByName('filemimetype',  ['mimeType' => 'image/png,image/jpeg'])
        ->attachByName('fileimagesize', ['maxWidth' => 1920, 'maxHeight' => 1080]);
        
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }


}