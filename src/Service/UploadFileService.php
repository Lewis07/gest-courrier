<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Upload file service
 */
class UploadFileService{

    private $param;

    /**
     * Constructor UploadFileService
     *
     * @param ParameterBagInterface $param
     */
    public function __construct(ParameterBagInterface $param)
    {
        $this->param = $param;
    }

    /**
     * upload file
     *
     * @param Object $form
     * @param Object $entity_name
     * @param String $entity_property
     * @param String $postfix
     * @return void
     */
    public function uploadFile($form, $entity_name, $entity_property, $service_parameter)
    {
        $file_uploaded = $form->get($entity_property)->getData();
        $method_set = 'set'.ucfirst($entity_property); 

        if(is_object($file_uploaded)){
            $destination = $this->param->get($service_parameter);
            $file = md5(uniqid()).'.'.$file_uploaded->guessExtension();

            $file_uploaded->move(
                $destination,
                $file
            );
            
            $entity_name->$method_set($file);
        }
    }

    /**
     * update file uploaded
     *
     * @param Object $form
     * @param Object $entity_name
     * @param String $entity_property
     * @param String $postfix
     * @return void
     */
    public function updateFileUploaded($form, $entity_name, $entity_property, $service_parameter)
    {
        $file_uploaded = $form->get($entity_property)->getData();
        $method_set = 'set'.ucfirst($entity_property); 

        if(is_object($file_uploaded)){
            $destination = $this->param->get($service_parameter);
            $file = md5(uniqid()).'.'.$file_uploaded->guessExtension();
            
            $this->deleteFile($entity_name, $entity_property, $service_parameter);

            $file_uploaded->move(
                $destination,
                $file
            );
            
            $entity_name->$method_set($file);
        }
    }

    /**
     * Delete file
     *
     * @param Object $entity_name
     * @param String $postfix
     * @param String $service_parameter
     * @return void
     */
    public function deleteFile($entity_name, $entity_property, $service_parameter)
    {
        $method_get = 'get'.ucfirst($entity_property);
        $file = $entity_name->$method_get();

        if ($file != "") {
           $old_file = $this->param->get($service_parameter).'/'.$file;
           unlink($old_file);
        }
    }
}