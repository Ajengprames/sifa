<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pemeriksaanibu_services
{


    function __construct()
    {
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }
    public function select_jeniskegiatan()
    {
        $this->load->model('jeniskegiatan_model');
        $jeniskegiatans = $this->jeniskegiatan_model->jeniskegiatans()->result();
        $select_jeniskegiatan = [];
        foreach ($jeniskegiatans as  $jeniskegiatan) {
            $select_jeniskegiatan[$jeniskegiatan->id] = $jeniskegiatan->name;
        }
        return $select_jeniskegiatan;
    }

    public function get_table_config($_page, $start_number = 1)
    {
        $select_jeniskegiatan = $this->select_jeniskegiatan();

        $table["header"] = array(
            'jeniskegiatan_name' => 'Jenis Kegiatan',
            'jadwal' => 'Tanggal Lahir',
            'imunisasiibu_name' => 'Jenis Imunisasi',
            'penyuluhanibu_name' => 'Jenis penyuluhan',
        );
        $table["number"] = $start_number;
        $table["action"] = array(
            array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_",
                "url" => site_url($_page . "edit/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "jeniskegiatan_id" => array(
                        'type' => 'select',
                        'label' => "Jenis Kegiatan",
                        'option' => $select_jeniskegiatan,
                    ),
                    "jadwal" => array(
                        'type' => 'date',
                        'label' => 'Tanggal Lahir',
                    ),
                    "imunisasiibu_id" => array(
                        'type' => 'select',
                        'label' => "Jenis Imunisasi",
                        //options' => $select_imunisasiibu,
                    ),
                    "penyuluhanibu_id" => array(
                        'type' => 'select',
                        'label' => 'Jenis Penyuluhan',
                        //'option' => $select_penyuluhanibu,
                    ),
                ),
                "title" => "Group",
            ),
            array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url($_page . "delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                ),
                "title" => "Group",
            ),
        );
        return $table;
    }
    public function get_table_group_config($_page, $start_number = 1)
    {
        $table["header"] = array(
            'name' => 'Jenis Kegiatan',
        );
        $table["number"] = $start_number;
        $table["action"] = array(
            array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_",
                "url" => site_url($_page . "edit/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "name" => array(
                        'type' => 'text',
                        'label' => "Jenis Kegiatan",
                    ),
                ),
                "title" => "Group",
            ),
            array(
                "name" => 'Hapus',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url($_page . "delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                ),
                "title" => "Group",
            ),
        );
        return $table;

        $table["header"] = array(
            'name' => 'Jenis Imunisasi',
        );
        $table["number"] = $start_number;
        $table["action"] = array(
            array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_",
                "url" => site_url($_page . "edit/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "name" => array(
                        'type' => 'text',
                        'label' => "Jenis Imunisasi",
                    ),
                ),
                "title" => "Group",
            ),
            array(
                "name" => 'Hapus',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url($_page . "delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                ),
                "title" => "Group",
            ),
        );
        return $table;

        $table["header"] = array(
            'name' => 'Jenis Penyuluhan',
        );
        $table["number"] = $start_number;
        $table["action"] = array(
            array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_",
                "url" => site_url($_page . "edit/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "name" => array(
                        'type' => 'text',
                        'label' => "Jenis Penyuluhan",
                    ),
                ),
                "title" => "Group",
            ),
            array(
                "name" => 'Hapus',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url($_page . "delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                ),
                "title" => "Group",
            ),
        );
        return $table;
    }
    public function validation_group_config()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'name',
                'rules' =>  'trim|required',
            ),
        );

        return $config;
    }
    public function validation_config()
    {
        $config = array(
            array(
                'field' => 'jeniskegiatan_id',
                'label' => 'Jenis Kegiatan',
                'rules' =>  'trim|required',
            ),
            array(
                'field' => 'jadwal',
                'label' => 'Jadwal Kegiatan',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'imunisasiibu_id',
                'label' => 'Jenis Imunisasi',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'penyuluhanibu_id',
                'label' => 'Jenis Penyuluhan',
                'rules' => 'trim|required',
            ),

        );

        return $config;
    }
    public function get_form_data($page)
    {
        $select_jeniskegiatan = $this->select_jeniskegiatan();
        // $select_imunisasiibu = $this->select_imunisasiibu();
        //$select_penyuluhanibu = $this->select_penyuluhanibu();
        $form_data = array(
            "name" => "Tambah Kegiatan",
            "modal_id" => "add_group_",
            "button_color" => "primary",
            "url" => site_url($page . "add/"),
            "form_data" => array(
                "jeniskegiatan_id" => array(
                    'type' => 'select',
                    'label' => "Jenis Kegiatan",
                    'option' => $select_jeniskegiatan,
                ),
                "jadwal" => array(
                    'type' => 'date',
                    'label' => 'Tanggal Lahir',
                ),
                "imunisasiibu_id" => array(
                    'type' => 'select',
                    'label' => "Jenis Imunisasi",
                    //          'options' => $select_imunisasiibu,
                ),
                "penyuluhanibu_id" => array(
                    'type' => 'select',
                    'label' => 'Jenis Penyuluhan',
                    //        'option' => $select_penyuluhanibu,
                ),
            ),
            'data' => NULL
        );
        return $form_data;
    }
}
