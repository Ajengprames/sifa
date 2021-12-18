<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ibuhamil extends Bidan_Controller
{
    private $services = null;
    private $name = null;
    private $parent_page = 'bidan';
    private $current_page = 'bidan/ibuhamil/';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('services/Pasienibu_services');
        $this->services = new Pasienibu_services;
        $this->load->model(array(
            'jk_model',
            'ibuhamil_model',
            'pemeriksaanibu_model',
        ));
    }
    public function index()
    {
        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1) : 0;
        // echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url($this->current_page) . '/index';
        $pagination['total_records'] = $this->ibuhamil_model->record_count();
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page * $pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
        //set pagination
        if ($pagination['total_records'] > 0) $this->data['pagination_links'] = $this->setPagination($pagination);
        #################################################################3
        $table = $this->services->get_table_config($this->current_page);
        $table["rows"] = $this->ibuhamil_model->ibuhamils($pagination['start_record'], $pagination['limit_per_page'])->result();
        $table = $this->load->view('templates/tables/plain_table', $table, true);
        $this->data["contents"] = $table;

        // $link_add =
        //     array(
        //         "name" => "Tambah Pemeriksaan",
        //         "type" => "link",
        //         "url" => site_url($this->current_page . "add/"),
        //         "button_color" => "primary",
        //         "data" => NULL,
        //     );
        // $this->data["header_button"] =  $this->load->view('templates/actions/link', $link_add, TRUE);;
        // $add_menu = $this->services->get_form_data($this->current_page);

        // $add_menu = $this->load->view('templates/actions/plain_form', $add_menu, true);

        // $this->data["header_button"] =  $add_menu;
        // return;
        #################################################################3
        $alert = $this->session->flashdata('alert');
        $this->data["key"] = $this->input->get('key', FALSE);
        $this->data["alert"] = (isset($alert)) ? $alert : NULL;
        $this->data["current_page"] = $this->current_page;
        $this->data["block_header"] = "Data Ibu Hamil";
        $this->data["header"] = "Group";
        $this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
        $this->render("templates/contents/plain_content");
    }


    public function add()
    {
        if (!($_POST)) redirect(site_url($this->current_page));

        // echo var_dump( $data );return;
        $this->form_validation->set_rules($this->services->validation_config());
        if ($this->form_validation->run() === TRUE) {
            // $data['name'] = $this->input->post('name');
            // $data['tgl_lahir'] = date_format(date_create($this->input->post('tgl_lahir')), 'Y-m-d');
            // $data['jk_id'] = $this->input->post('jk_id');
            // $data['alamat'] = $this->input->post('alamat');
            // $data['no_hp'] = $this->input->post('no_hp');
            $data = array(
                'name' => $this->input->post('name'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'jk_id' => $this->input->post('jk_id'),
                'alamat' => $this->input->post('alamat'),
                'no_hp' => $this->input->post('name'),

            );
            $data['darah'] = $this->input->post('darah');
            $data['bb'] = $this->input->post('bb');
            $data['jantung'] = $this->input->post('jantung');
            $data['suhu'] = $this->input->post('suhu');
            $data['imunisasiibu_id'] = $this->input->post('imunisasiibu_id');
            $data['penyuluhanibu_id'] = $this->input->post('penyuluhanibu_id');

            if ($this->pemeriksaanibu_model->create($data)) {
                $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::SUCCESS, $this->pemeriksaanibu_model->messages()));
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->pemeriksaanibu_model->errors()));
            }
        } else {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->pemeriksaanibu_model->errors() : $this->session->flashdata('message')));
            if (validation_errors() || $this->pemeriksaanibu_model->errors()) $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->data['message']));

            $alert = $this->session->flashdata('alert');
            $this->data["key"] = $this->input->get('key', FALSE);
            $this->data["alert"] = (isset($alert)) ? $alert : NULL;
            $this->data["current_page"] = $this->current_page;
            $this->data["block_header"] = "Tambah User ";
            $this->data["header"] = "Tambah User ";
            $this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->ion_auth->get_form_data();
            $form_data = $this->load->view('templates/form/plain_form', $form_data, TRUE);

            $this->data["contents"] =  $form_data;

            $this->render("templates/contents/plain_content_form");
        }
    }

    public function edit()
    {
        if (!($_POST)) redirect(site_url($this->current_page));

        // echo var_dump( $data );return;
        $this->form_validation->set_rules($this->services->validation_config());
        if ($this->form_validation->run() === TRUE) {
            $data['name'] = $this->input->post('name');
            $data['tgl_lahir'] = $this->input->post('tgl_lahir');
            $data['jk_id'] = $this->input->post('jk_id');
            $data['alamat'] = $this->input->post('alamat');
            $data['no_hp'] = $this->input->post('no_hp');

            $data_param['id'] = $this->input->post('id');

            if ($this->pemeriksaanibu_model->update($data, $data_param)) {
                $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::SUCCESS, $this->pemeriksaanibu_model->messages()));
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->pemeriksaanibu_model->errors()));
            }
        } else {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->pemeriksaanibu_model->errors() : $this->session->flashdata('message')));
            if (validation_errors() || $this->pemeriksaanibu_model->errors()) $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->data['message']));
        }
    }

    public function delete()
    {
        if (!($_POST)) redirect(site_url($this->current_page));

        $data_param['id']     = $this->input->post('id');
        if ($this->pemeriksaanibu_model->delete($data_param)) {
            $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::SUCCESS, $this->pemeriksaanibu_model->messages()));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->pemeriksaanibu_model->errors()));
        }
    }
}
