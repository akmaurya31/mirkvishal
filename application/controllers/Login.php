<?php 

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('backend/login');
    }

    function ajax_login() {
        $response = array();
        $email = $this->input->post("email");
        $password = $this->input->post("password");

        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;

        if ($login_status == 'success') {
            // Return dashboard URL so JS can redirect
            $response['redirect_url'] = base_url('index.php?admin/dashboard');
        }

        echo json_encode($response); // AJAX expects JSON, not PHP redirect
    }

    function validate_login($email = '', $password = '') {
        $credential = array('email' => $email, 'password' => $password);
        $query = $this->db->get_where('admin', $credential);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            // Use CodeIgniter session
            $this->session->set_userdata('admin_login', 1);
            $this->session->set_userdata('admin_id', $row->admin_id);
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'admin');

            return 'success';
        }

        return 'invalid';
    }

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }
}
