<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Content extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['title'] = 'Beranda';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->select('table_content.*, user.name, user.image,');
        $this->db->join('user', 'user.id = table_content.writer_id');
        $data['content'] = $this->db->get_where('table_content', ['status_publish' => 'public'])->result_array();

        $data['kategori'] = $this->db->get('kategori')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('content/beranda', $data);
        $this->load->view('templates/footer');
    }

    public function contentView()
    {
        $data['title'] = 'Beranda';
        $result = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['user'] = $result;

        $userId = $result['id'];

        // $data['content_title'] = $content['content_title'];
        // $data['content_body'] = $content['content_body'];
        // $data['content_id'] = $content['content_id'];
        // $data['date_created_content'] = $content['date_created_content'];

        // mengambil nilai content id dari url di segment ke 3
        $contentId = $this->uri->segment('3');

        // mengambil data dari table content yang content id nya sama dengan content id yang sudah kita ambil dari url
        $data['content'] = $this->db->get_where('table_content', ['content_id' => $contentId])->row_array();

        // mengambil data user yang join di table content dengan content id nya sama dengan content id yang sudah kita ambil di url
        $this->db->select('image, name');
        $this->db->join('user', 'user.id = table_content.writer_id');
        $data['content_user'] = $this->db->get_where('table_content', ['content_id' => $contentId])->row_array();

        $this->db->select('table_comment.*, user.name, user.email, user.image');
        $this->db->join('user', 'user.id = table_comment.user_id');
        $data['queryParent'] = $this->db->get_where('table_comment', ['parent_id' => 0, 'content_id' => $contentId])->result_array();

        $dataKunjungan = $this->db->get_where('data_kunjungan', ['content_id' => $contentId, 'user_id' => $userId])->row_array();
        if ($dataKunjungan == null) {
            $data['data_kunjungan'] = "0";
        } else {
            $data['data_kunjungan'] = $dataKunjungan;
        }


        // $this->db->select('id');
        // $id = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $data['coba'] = $id;
        // untuk sistem komentar
        // $this->db->order_by('id', 'DESC');
        // $data['queryParent'] = $this->db->get_where('table_comment', ['parent_id' => 0, 'content_id' => $id])->result_array();


        // ini view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('content/content-view', $data);
        $this->load->view('templates/footer');
    }

    public function nyoba()
    {
        $data['title'] = "Bootstrap";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('content/nyoba', $data);
        $this->load->view('templates/footer');
    }

    public function insertKomentar()
    {
        $content_id = $this->input->post('content_id');

        $this->form_validation->set_rules('isi', 'Isi Komentar', 'required|trim');

        $data = [
            'parent_id' => $this->input->post('parent'),
            'user_id' => $this->input->post('user_id'),
            'isi' => htmlspecialchars($this->input->post('isi', true)),
            'content_id' => $content_id,
            'date_created' => time()
        ];
        $this->db->insert('table_comment', $data);
        redirect('content/contentView/' . $content_id);
    }

    public function insertBalasKomentar()
    {
        $parentId = $this->input->post('parentId');
        $isi = $this->input->post('balasan', true);
        $contentId = $this->input->post('contentId');
        $userId = $this->input->post('userId');
        $dateCreated = time();

        $data = [
            'parent_id' => $parentId,
            'isi' => $isi,
            'content_id' => $contentId,
            'user_id' => $userId,
            'date_created' => $dateCreated
        ];

        $this->db->insert('table_comment', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">comment has been updated!</div>');
        redirect('Content/contentView/' . $contentId . '#display_comment');
    }

    public function like($contentId = 0)
    {

        $result = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $userId = $result['id'];

        $query = $this->db->get_where('data_kunjungan', ['content_id' => $contentId, 'user_id' => $userId])->row_array();
        $id = $query['id'];

        if ($query != null) {
            $like = $query['status_like'];
            if ($like == "1") {
                $like = 0;
                $this->db->where('id', $id);
                $this->db->update('data_kunjungan', ['status_like' => $like]);
            } else {
                $like = 1;
                $this->db->where('id', $id);
                $this->db->update('data_kunjungan', ['status_like' => $like]);
            }
        } else {
            $data = [
                'content_id' => $contentId,
                'user_id' => $userId,
                'status_like' => 1,
            ];

            $this->db->insert('data_kunjungan', $data);
        }
    }

    public function view($contentId = 0)
    {
        $result = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $userId = $result['id'];
        $query = $this->db->get_where('data_kunjungan', ['content_id' => $contentId, 'user_id' => $userId])->row_array();
        if ($query != null) {
            redirect('content/content-view/' . $contentId);
        } else {
            $data = [
                'content_id' => $contentId,
                'user_id' => $userId,
                'status_like' => 0,
            ];

            $this->db->insert('data_kunjungan', $data);
        }
    }

    public function chat()
    {
        $data['title'] = "Ruang Obrolan";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('content/chat', $data);
        $this->load->view('templates/footer');
    }
}
