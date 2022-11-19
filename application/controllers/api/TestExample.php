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
class TestExample extends REST_Controller 
{
    public function index_get(){
        $this->response([
            'status' => 'success',
            'message' => 'API EXAMPLE Berhasil Di Panggil'
        ], REST_Controller::HTTP_OK);
    }

    public function images_all_get() 
    {
        $images = $this->db->get('images')->result_array();

        if($images != null)
        {
            $this->response([
                'status' => 'success',
                'message' => 'Data Images Berhasil Ditemukan',
                'images' => $images
            ],REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No images were found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }
}