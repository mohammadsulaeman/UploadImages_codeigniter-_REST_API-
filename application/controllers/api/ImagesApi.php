<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class ImagesApi extends REST_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("ImagesModel", 'imgM');
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index_get()
    {
        $this->response([
            'code' => REST_Controller::HTTP_OK,
            'status' => 'success',
            'message' => 'API Images Berhasil Di Buat'
        ],REST_Controller::HTTP_OK);
    }

    public function imagesById($id)
    {
        $image = $this->imgM->detail($id);
        if($image)
        {
            $message = array(
                'code' => REST_Controller::HTTP_OK, 
                'status' => 'success',
                'message' => 'Data Images Berhasil Di ditemukan',
                'data' => $image
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }else{
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'status' => 'failed',
                'message' => 'Data Images Gagal Di temukan',
                'data' => $image
             );
             $this->response($message,REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function insertImages_post()
    {
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $image = $dec_data->cover;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "images/cover/" . $namafoto;
        file_put_contents($path, base64_decode($image));
        $data_images = array(
            'image_id' => $dec_data->image_id,
            'cover' => $namafoto,
            'title' => $dec_data->title,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $insertImages = $this->imgM->insert_images($data_images);
        if($insertImages)
        {
            $message = array(
                'code' => REST_Controller::HTTP_OK, 
                'status' => 'success',
                'message' => 'Data Images Berhasil Di Simpan',
                'data' => $insertImages
            );
            $this->response($message, REST_Controller::HTTP_OK);
        }else{
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'status' => 'failed',
                'message' => 'Data Images Gagal Di Simpan',
                'data' => $insertImages
             );
             $this->response($message,REST_Controller::HTTP_NOT_FOUND);
        }
        
    }

    public function image_all_get()
    {
        $images = $this->imgM->selectImagesAll();
        if($images)
        {
            $message = array(
                'code' => REST_Controller::HTTP_OK,
                'status' => 'success',
                'message' => 'Data Images Berhasil Di Temukan',
                'images' => $images
            );
            $this->response($message,REST_Controller::HTTP_OK);
        }else
        {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'status' => 'failed',
                'message' => 'Data Images Gagal Di Temukan',
                'data' => $images
             );
             $this->response($message,REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function update_images_post($imageid)
    {
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $image = $dec_data->cover;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "images/cover/" . $namafoto;
        file_put_contents($path, base64_decode($image));
        $update_images = array(
            'title' => $dec_data->title,
            'cover' => $namafoto,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $dataImageId =  array('image_id' => $imageid );

        $updateImages = $this->imgM->updateImages($update_images,$dataImageId);
        if ($updateImages) {
            # code...
            $message = array(
                'code' => REST_Controller::HTTP_OK,
                'status' => 'success',
                'message' => 'Data Images Berhasil Di Update',
                'data' => $update_images 
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }else 
        {
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'status' => 'failed',
                'message' => 'Update Images Gagal Di Temukan',
                'data' => $update_images
             );
             $this->response($message,REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function delete_images_delete($imageid)
    {
        $images = $this->imgM->detail($imageid);
        unlink('images/cover/'. $images->cover);

        $data = array('image_id' => $imageid);
        $image = $this->imgM->deleteImages($data);

        if ($image) {
            # code...
            $message = array(
                'code' => REST_Controller::HTTP_OK,
                'status' => 'success',
                'message' => 'Data Images Berhasil Di Delete',
                'data' => $data 
            );

            $this->response($message, REST_Controller::HTTP_OK);
        }else{
            $message = array(
                'code' => REST_Controller::HTTP_NOT_FOUND,
                'status' => 'failed',
                'message' => 'Data Images Gagal Di Delete',
                'data' => $data
             );
             $this->response($message,REST_Controller::HTTP_NOT_FOUND);
        }
    }
}