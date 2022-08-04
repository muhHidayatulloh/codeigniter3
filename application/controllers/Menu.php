<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'trim|required');

        if ($this->form_validation->run() == false) {
            // load data view
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added</div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'trim|required');
        $this->form_validation->set_rules('url', 'URL', 'trim|required');
        if ($this->input->post('icon') == null) {
            $this->form_validation->set_rules('iconInput', 'icon', 'trim|required');
        } else {
            $this->form_validation->set_rules('icon', 'icon', 'trim|required');
        }

        if ($this->form_validation->run() == false) {
            // load data view
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->input->post('icon') == null) {
                $icon = $this->input->post('iconInput');
            } else {
                $icon = $this->input->post('icon');
            }
            $data = [
                'title' => htmlspecialchars($this->input->post('title', true)),
                'idMenu' => $this->input->post('menu_id', true),
                'url' => htmlspecialchars($this->input->post('url', true)),
                'icon' => $icon,
                'is_active' => $this->input->post('is_active'),
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added</div>');
            redirect('menu/submenu');
        }
    }

    public function subMenuEdit()
    {
        $id = $_POST['id'];
        echo json_encode($this->db->get_where('user_sub_menu', ['id' => $id])->row_array());
    }

    public function ubahSubMenu()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $menu = $_POST['menu_id'];
        $url = $_POST['url'];
        $isActive = $_POST['is_active'];
        if ($_POST['icon'] != null) {
            $icon = $_POST['icon'];
        } else if ($_POST['iconInput'] != null) {
            $icon = $_POST['iconInput'];
        } else {
            $icon = $_POST['iconDefault'];
        }

        $data = [
            'idMenu' => $menu,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'is_active' => $isActive
        ];

        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your sub menu has been edited</div>');
        redirect('menu/submenu');
    }

    public function menuEdit()
    {
        $id = $_POST['id'];
        echo json_encode($this->db->get_where('user_menu', ['id' => $id])->row_array());
    }

    public function ubahMenu()
    {
        $id = $_POST['id'];
        $menu = $_POST['menu'];
        $this->db->where('id', $id);
        $this->db->update('user_menu', ['menu' => $menu]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Menu name has been edited</div>');
        redirect('menu');
    }

    public function deleteDataMenu()
    {
        $id = $_POST['id'];
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your <b>Menu</b> name has been <b>deleted</b></div>');
        redirect('menu');
    }

    public function deleteDataSubMenu()
    {
        $id = $_POST['id'];
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your <b>Sub Menu</b> name has been <b>deleted</b></div>');
        redirect('menu/submenu');
    }
}
