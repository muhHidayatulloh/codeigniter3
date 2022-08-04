x<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function editProfile()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            //cek jika ada gambar yang diuload
            $uploadImage = $_FILES['image']['name'];
            
            if ($uploadImage) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $oldImage = $data['user']['image'];
                    if ($oldImage != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $oldImage);
                    }
                    $newImage = $this->upload->data('file_name');
                    $this->db->set('image', $newImage);
                } else {
                    $this->upload->display_errors();
                }
            }
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
            redirect('user');
        }
    }

    // public function balasKomentar()
    // {
    //     $comment_id = $this->input->post('comment_id');
    //     $content_id = $this->input->post('content_id');
    //     $name = $this->input->post('name');
    //     $email = $this->input->post('email');
    //     $isi = $this->input->post('isi');
    //     $this->db->insert('table_comment', ['', $comment_id, $name, $email, $isi, $content_id]);
    //     redirect('user/beranda/' . $content_id);
    // }

    public function kotaksaran()
    {
        $data['title'] = 'Kotak Saran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/kotak-saran', $data);
        $this->load->view('templates/footer');
    }


    public function contentmanagement()
    {
        $data['title'] = 'Content Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['content'] = $this->db->get_where('table_content', ['writer_id' => $data['user']['id']])->result_array();
        $data['kategori'] = $this->db->get('kategori')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/content-management', $data);
        $this->load->view('templates/footer');
    }

    public function writeArticle()
    {
        $data['title'] = "Write Your Article";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('articleBody', 'Tulis Artikel', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/content-management', $data);
            $this->load->view('templates/footer');
        } else {

            $content_id = $this->input->post('content_id');

            // jika kontent id terisi berarti sudah ada maka
            if ($content_id != null) {

                $array = [
                    'kategori_id' => $this->input->post('kategori'),
                    'content_title' => $this->input->post('title', true),
                    'content_body' => $this->input->post('articleBody'),
                    'status_publish' => $this->input->post('privasi'),
                    'date_created_content' => time()
                ];
                $this->db->set($array);
                $this->db->where('content_id', $content_id);
                $this->db->update('table_content');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Article has been Edited!</div>');
                redirect('user/contentmanagement');
            } else {
                $data = [
                    'writer_id' => htmlspecialchars($this->input->post('id', true)),
                    'kategori_id' => $this->input->post('kategori'),
                    'content_title' => $this->input->post('title', true),
                    'content_body' => $this->input->post('articleBody'),
                    'status_publish' => $this->input->post('privasi'),
                    'date_created_content' => time()
                ];
                $this->db->insert('table_content', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your Article has been created!</div>');
                redirect('user/contentmanagement');
            }
            redirect('user/contentmanagement');
        }
    }

    public function editContent()
    {
        $contentId = $this->input->post('contentId');
        echo json_encode($this->db->get_where('table_content', ['content_id' => $contentId])->row_array());
    }

    public function deleteContent()
    {
        $id = $_POST['id'];
        $this->db->where('content_id', $id);
        $this->db->delete('table_content');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your <b>Content</b> name has been <b>deleted</b></div>');
        redirect('user/contentmanagement');
    }
}
