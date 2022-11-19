<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ImagesModel extends CI_model
{
    public function insert_images($data_images)
    {
        $insertImages = $this->db->insert('image',$data_images);
        return $insertImages;
    }

    public function selectImagesAll()
    {
        return $this->db->get('image')->result_array();
    }

    public function updateImages($update_images,$dataImageId)
    {
        $updateImages = $this->db->update('image',$update_images,$dataImageId);
        return $updateImages;
    }

    public function detail($id)
    {
        $this->db->select('*');
        $this->db->from('image');
        $this->db->where('image_id', $id);
        $this->db->order_by('image_id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function deleteImages($data)
    {

        $deleteImages =  $this->db->delete('image', $data);
        return $deleteImages;

    }


}