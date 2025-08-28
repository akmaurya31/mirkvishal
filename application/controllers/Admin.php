<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 
class Admin extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
        session_start();
        $_SESSION['admin_login'] = 1;
       /*cache control*/
		// $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		// $this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($_SESSION['admin_login'] != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($_SESSION['admin_login'] == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        // if ($_SESSION['admin_login'] != 1){
        //     redirect(base_url(), 'refresh');
        // }
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = 'Admin Dashboard';
        $this->load->view('backend/index', $page_data);
    }
    
    
    /****MANAGE STUDENTS CLASSWISE*****/
	function student_add()
	{
		// if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
			
		$page_data['page_name']  = 'student_add';
		$page_data['page_title'] = 'Add Student';
		$this->load->view('backend/index', $page_data);
	}
	
	
	    /****MANAGE Academic Session*****/
	
	function acd_session($param1 = '', $param2 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
			$data['strt_dt'] = date('Y-m-d',strtotime($this->input->post('strt_dt')));
            $data['end_dt'] = date('Y-m-d',strtotime($this->input->post('end_dt')));
            $data['is_open']   = $this->input->post('is_open');
            $this->db->insert('acd_session', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/acd_session/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
          	$data['strt_dt'] = date('Y-m-d',strtotime($this->input->post('strt_dt')));
            $data['end_dt'] = date('Y-m-d',strtotime($this->input->post('end_dt')));
            $data['is_open']   = $this->input->post('is_open');
            
            $this->db->where('id', $param2);
            $this->db->update('acd_session', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/acd_session/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('acd_session', array(
                'id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('acd_session');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/acd_session/', 'refresh');
        }
        $page_data['acdSession']    = $this->db->get('acd_session')->result_array();
        $page_data['page_name']  = 'acd_session';
		$page_data['page_title'] = 'Academic Session';
        $this->load->view('backend/index', $page_data);
    }
	 /****MANAGE ONLINE ADMISSION*****/
	function online_admission($param1 = '', $param2 = '', $param3 = '')
     {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
			
				
        if ($param1 == 'create') {
		
		if($_FILES['userfile']['name'] != '') {
		    $filename = stripslashes($_FILES['userfile']['name']); 
            $extension = strtolower($filename);	
		    $image_name1=time().'.'.$extension;
		    $newname='uploads/student_image/'.$image_name1;
		    $copied = copy($_FILES['userfile']['tmp_name'], $newname);
	        }
		
		    $data['acd_session_id']        = $this->input->post('acd_session_id');
            $data['name_bn']        = $this->input->post('name_bn');
			$data['name_en']        = $this->input->post('name_en');
			$data['father_name']        = $this->input->post('father_name');
			$data['mother_name']        = $this->input->post('mother_name');
			$data['ff_son']        = $this->input->post('ff_son');
			$data['upjati']        = $this->input->post('upojati');
			$data['gardian_name']        = $this->input->post('gardian_name');
			$data['nationality']        = $this->input->post('nationality');
            $data['birthday']    = $this->input->post('birthday');
			$data['religion']    = $this->input->post('religion');
            $data['sex']         = $this->input->post('sex');
            $data['pr_address']     = $this->input->post('pr_address');
			$data['cur_address']     = $this->input->post('cur_address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $data['technology']    = $this->input->post('technology');
			$data['app_date']    = date('Y-m-d');
			$photo=time().'.jpg';
			$data['photo']    = $image_name1;
            $this->db->insert('osad_student', $data);
            $osad_student_id = $this->db->insert_id();
			// Details 
	        for($i=0;$i<$this->input->post('ttldtl');$i++){
	
	        $data1 = array(
	           'osad_student_id' => $osad_student_id,
	           'examtype' => $this->input->post('examtype'.$i, TRUE),
			   'group' => $this->input->post('group'.$i, TRUE),
               'board' => $this->input->post('board'.$i, TRUE),
			   'passing_yr' => $this->input->post('passing_yr'.$i, TRUE),
			   'special_mark' => $this->input->post('special_mark'.$i, TRUE),
			   'ttl_mark' => $this->input->post('ttl_mark'.$i, TRUE),
			   'date' => date('Y-m-d')
			   );
			   
			    $this->db->insert('osad_acd_history', $data1);
			   
			   }
			   
	/*	if($_FILES['userfile']['userfile'] != '') {
		//$filename = stripslashes($_FILES['upload']['name']); 
		//$extension = strtolower($filename);	
		//$image_name1=time().'.'.$extension;
		$newname='uploads/student_image/'.$photo;
		$copied = copy($_FILES['userfile']['tmp_name'], $newname);
	     }*/

           // move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/'.$photo);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            //$this->email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/online_admission/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            
            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/online_admission/', 'refresh');
        } else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('teacher', array(
                'teacher_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('teacher');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/online_admission/', 'refresh');
        }
	
		$page_data['osadStudent']    = $this->db->get('osad_student')->result_array();
        $page_data['page_name']  = 'online_admission';
		$page_data['page_title'] = 'Online Admission';
        $this->load->view('backend/index', $page_data);
    }
	
	function osadStudRept($param1 = ''){
	
	    // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
			
	    $page_data['osadStudent']    = $this->db->get('osad_student', array(
                'id' => $param1
            ))->result_array();
			$page_data['acdSession']    = $this->db->get('acd_session', array(
                'is_open' =>'1'
            ))->result_array();
			$page_data['osadacdhistory']    = $this->db->get_where('osad_acd_history', array(
                'osad_student_id' => $param1
            ))->result_array();
        $page_data['page_name']  = 'online_admission';
		$page_data['page_title'] = 'Online Admission';
        $this->load->view('backend/admin/onlineAdmissionRept', $page_data);
		
		//$this->load->helper(array('dompdf', 'file'));
	    //$html=$this->load->view('backend/admin/onlineAdmissionRept', $page_data, true);     
        //pdf_create($html, 'AdmissionForm-'.$param1);
			
	}
	 
	function student_information($class_id = '')
	{
		// if ($_SESSION['admin_login'] != 1)
        //     redirect('login', 'refresh');
			
		$page_data['page_name']  	= 'student_information';
		$page_data['page_title'] 	= 'Student Information'. " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
	function student_marksheet($class_id = '')
	{
		if ($_SESSION['admin_login'] != 1)
            redirect('login', 'refresh');
			
		$page_data['page_name']  = 'student_marksheet';
		$page_data['page_title'] 	= 'Student Marksheet'. " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
    function student($param1 = '', $param2 = '', $param3 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['birthday']   = $this->input->post('birthday');
            $data['sex']        = $this->input->post('sex');
            $data['address']    = $this->input->post('address');
            $data['phone']      = $this->input->post('phone');
            $data['email']      = $this->input->post('email');
            $data['password']   = $this->input->post('password');
            $data['adharcard']   = $this->input->post('adharcard');

            $data['father_name']   = $this->input->post('father_name');
            $data['mother_name']   = $this->input->post('mother_name');
            $data['grdname']   = $this->input->post('graduation_name');
            $data['grd_adharcard']   = $this->input->post('grd_adharcard');

            $data['add_date']   = $this->input->post('add_date');

            $data['class_id']   = $this->input->post('class_id');
            if ($this->input->post('section_id') != '') {
                $data['section_id'] = $this->input->post('section_id');
            }
            $data['parent_id']  = $this->input->post('parent_id');
            $data['roll']       = $this->input->post('roll');
            $this->db->insert('student', $data);
            $student_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/student_add/' . $data['class_id'], 'refresh');
        }
        if ($param2 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $data['class_id']    = $this->input->post('class_id');
            $data['section_id']  = $this->input->post('section_id');
            $data['parent_id']   = $this->input->post('parent_id');
            $data['roll']        = $this->input->post('roll');
            
            $this->db->where('student_id', $param3);
            $this->db->update('student', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
            $this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/student_information/' . $param1, 'refresh');
        } 
		
        if ($param2 == 'delete') {
            $this->db->where('student_id', $param3);
            $this->db->delete('student');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/student_information/' . $param1, 'refresh');
        }
    }
     /****MANAGE PARENTS CLASSWISE*****/
    function parent($param1 = '', $param2 = '', $param3 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']        			= $this->input->post('name');
            $data['email']       			= $this->input->post('email');
            $data['password']    			= $this->input->post('password');
            $data['phone']       			= $this->input->post('phone');
            $data['address']     			= $this->input->post('address');
            $data['profession']  			= $this->input->post('profession');
            $data['adharcard']  			= $this->input->post('adharcard');
            $this->db->insert('parent', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('parent', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?admin/parent/', 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']                   = $this->input->post('name');
            $data['email']                  = $this->input->post('email');
            $data['phone']                  = $this->input->post('phone');
            $data['address']                = $this->input->post('address');
            $data['profession']             = $this->input->post('profession');
            $this->db->where('parent_id' , $param2);
            $this->db->update('parent' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/parent/', 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('parent_id' , $param2);
            $this->db->delete('parent');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/parent/', 'refresh');
        }
        $page_data['page_title'] 	= 'All Parents';
        $page_data['page_name']  = 'parent';
        $this->load->view('backend/index', $page_data);
    }
	
    
  
    
    
    /****MANAGE CLASSES*****/
    function classes($param1 = '', $param2 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            $data['name_numeric'] = $this->input->post('name_numeric');
            $data['teacher_id']   = $this->input->post('teacher_id');
            $this->db->insert('class', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            $data['name_numeric'] = $this->input->post('name_numeric');
            $data['teacher_id']   = $this->input->post('teacher_id');
            
            $this->db->where('class_id', $param2);
            $this->db->update('class', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class', array(
                'class_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_id', $param2);
            $this->db->delete('class');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        $page_data['classes']    = $this->db->get('class')->result_array();
        $page_data['page_name']  = 'class';
        $page_data['page_title'] = 'Manage Class';
        $this->load->view('backend/index', $page_data);
    }
 

    function get_class_section($class_id)
    {
        $sections = $this->db->get_where('section' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_subject($class_id)
    {
        $subjects = $this->db->get_where('subject' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($subjects as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

     
 
    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['amount_paid']        = $this->input->post('amount_paid');
            $data['due']                = $data['amount'] - $data['amount_paid'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            $data2['invoice_id']        =   $invoice_id;
            $data2['student_id']        =   $this->input->post('student_id');
            $data2['title']             =   $this->input->post('title');
            $data2['description']       =   $this->input->post('description');
            $data2['payment_type']      =  'income';
            $data2['method']            =   $this->input->post('method');
            $data2['amount']            =   $this->input->post('amount_paid');
            $data2['timestamp']         =   strtotime($this->input->post('date'));

            $this->db->insert('payment' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);

            $data2['amount_paid']   =   $this->input->post('amount');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');

            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = 'Manage Invoice/Payment';
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

 

    function income($param1 = '' , $param2 = '')
    {
        //    if ($_SESSION['admin_login'] != 1)
        //      redirect('login', 'refresh');

          if ($param1 == 'filter') { 
            //  die("SDffff");
            $this->income_filter();
            exit;
          }


        $page_data['page_name']  = 'income';
        $page_data['page_title'] = 'Incomes';
        $this->db->where('MONTH(FROM_UNIXTIME(creation_timestamp))', date('m'));
        $this->db->where('YEAR(FROM_UNIXTIME(creation_timestamp))', date('Y'));
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }




    public function income_filter() {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');

        $this->db->where('payment_type', 'income');

        if(!empty($from_date) && !empty($to_date)) {
            $from_timestamp = strtotime($from_date . "-01");
            $to_timestamp   = strtotime($to_date . "-01 +1 month -1 day");
            $this->db->where('timestamp >=', $from_timestamp);
            $this->db->where('timestamp <=', $to_timestamp);
        }

        $this->db->order_by('timestamp', 'desc');
        $expenses = $this->db->get('payment')->result_array();
       // print_r($expenses);
        // echo $this->db->last_query(); 
        // die("Asdf");

        $html = '';
        $count = 1;
        $total = 0;

       if(!empty($expenses)) {
        foreach($expenses as $row) {
            $catName = '';
            $method = '';
            if ($row['method'] == 1) $method = 'Cash';
            if ($row['method'] == 2) $method = 'Cheque';
            if ($row['method'] == 3) $method = 'Card';
            $stcl=$this->expense_model->getStudent($row['student_id']);

            $html .= '
            <tr>
                <td>'.$count++.'</td>
                <td>'.$row['title'].'</td>
                <td>'.$row['description'].'</td>
                <td>'.$stcl.'</td>
                <td>'.$method.'</td>
                <td>'.(!empty($row['amount']) ? $row['amount'] : 0).'</td>
                <td>'.date('d M,Y', $row['timestamp']).'</td>
            </tr>';
           $total += !empty($row['amount']) ? $row['amount'] : 0;
        }
       }

        echo json_encode([
            'total' => $total,
            'expenses' => $expenses,
            'html' => $html
        ]);
    }

    public function income_export_csv() {
    $from_date = $this->input->get('from_date');
    $to_date   = $this->input->get('to_date');

    $this->db->where('payment_type', 'income');

    if (!empty($from_date) && !empty($to_date)) {
        $from_timestamp = strtotime($from_date . "-01 00:00:00");
        $to_timestamp   = strtotime($to_date . "-01 +1 month -1 day 23:59:59");
        $this->db->where('timestamp >=', $from_timestamp);
        $this->db->where('timestamp <=', $to_timestamp);
    }

    $this->db->order_by('timestamp', 'desc');
    $expenses = $this->db->get('payment')->result_array();

    // Set CSV headers
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=incomes.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $output = fopen("php://output", "w");

    // CSV Header row
    fputcsv($output, array('ID', 'Title', 'Description', 'StudentClass', 'Amount', 'Method', 'Date'));

    // CSV Data rows
    foreach ($expenses as $row) {
        $method = '';
        if ($row['method'] == 1) $method = 'Cash';
        if ($row['method'] == 2) $method = 'Cheque';
        if ($row['method'] == 3) $method = 'Card';
        $stcl=$this->expense_model->getStudent($row['student_id']);

        fputcsv($output, array(
            $row['payment_id'],
            $row['title'],
            $row['description'],
            $stcl,
            $row['amount'],
            $method,
            date('d M, Y', $row['timestamp'])
        ));
    }

    fclose($output);
    exit;
}


    public function expense_filter() {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');

        $this->db->where('payment_type', 'expense');

        if(!empty($from_date) && !empty($to_date)) {
            $from_timestamp = strtotime($from_date . "-01");
            $to_timestamp   = strtotime($to_date . "-01 +1 month -1 day");
            $this->db->where('timestamp >=', $from_timestamp);
            $this->db->where('timestamp <=', $to_timestamp);
        }

        $this->db->order_by('timestamp', 'desc');
        $expenses = $this->db->get('payment')->result_array();
        // echo $this->db->last_query(); 

        $html = '';
        $count = 1;
        $total = 0;

        foreach($expenses as $row) {
            $catName = '';
            if (!empty($row['expense_category_id'])) {
                $cat = $this->db->get_where('expense_category', ['expense_category_id' => $row['expense_category_id']])->row();
                $catName = $cat ? $cat->name : '';
            }

            $method = '';
            if ($row['method'] == 1) $method = 'Cash';
            if ($row['method'] == 2) $method = 'Cheque';
            if ($row['method'] == 3) $method = 'Card';

            $html .= '
            <tr>
                <td>'.$count++.'</td>
                <td>'.$row['title'].'</td>
                <td>'.$catName.'</td>
                <td>'.$method.'</td>
                <td>'.(!empty($row['amount']) ? $row['amount'] : 0).'</td>
                <td>'.date('d M,Y', $row['timestamp']).'</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                            <li><a href="#" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/modal_view_slip/'.$row['payment_id'].'\');"><i class="entypo-credit-card"></i> Slip</a></li>
                            <li class="divider"></li>
                            <li><a href="#" onclick="showAjaxModal(\''.base_url().'index.php?modal/popup/expense_edit/'.$row['payment_id'].'\');"><i class="entypo-pencil"></i> Edit</a></li>
                            <li class="divider"></li>
                            <li><a href="#" onclick="confirm_modal(\''.base_url().'index.php?admin/expense/delete/'.$row['payment_id'].'\');"><i class="entypo-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>';
            $total += !empty($row['amount']) ? $row['amount'] : 0;

        }

        echo json_encode([
            'total' => $total,
            'expenses' => $expenses,
            'html' => $html
        ]);
}

  public function expense_export_csv() {
    $from_date = $this->input->get('from_date');
    $to_date   = $this->input->get('to_date');

    $this->db->where('payment_type', 'expense');

    if (!empty($from_date) && !empty($to_date)) {
        $from_timestamp = strtotime($from_date . "-01 00:00:00");
        $to_timestamp   = strtotime($to_date . "-01 +1 month -1 day 23:59:59");
        $this->db->where('timestamp >=', $from_timestamp);
        $this->db->where('timestamp <=', $to_timestamp);
    }

    $this->db->order_by('timestamp', 'desc');
    $expenses = $this->db->get('payment')->result_array();

    // Set CSV headers
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=expense.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $output = fopen("php://output", "w");

    // CSV Header row
    fputcsv($output, array('ID', 'Title', 'Description',  'Amount', 'Method', 'Date'));

    // CSV Data rows
    foreach ($expenses as $row) {
        $method = '';
        if ($row['method'] == 1) $method = 'Cash';
        if ($row['method'] == 2) $method = 'Cheque';
        if ($row['method'] == 3) $method = 'Card';

        $catName = '';
        if (!empty($row['expense_category_id'])) {
            $cat = $this->db->get_where('expense_category', ['expense_category_id' => $row['expense_category_id']])->row();
            $catName = $cat ? $cat->name : '';
        }

        fputcsv($output, array(
            $row['payment_id'],
            $row['title'],
            $row['description'],
            $catName,
            $row['amount'],
            $method,
            date('d M, Y', $row['timestamp'])
        ));
    }

    fclose($output);
    exit;
}

public function expense($param1 = '', $param2 = '', $param3 = '') {
      if ($_SESSION['admin_login'] != 1)
            redirect('login', 'refresh');

      if ($param1 == 'filter') { 
        //  die("SDffff");
        $this->expense_filter();
        exit;
      }


    // if ($param1 == 'delete') {
    //     $this->db->where('payment_id', $param2);
    //     $this->db->delete('payment');
    //     redirect(base_url().'index.php?admin/expense', 'refresh');
    // }
    // $page_data['page_name']  = 'expense';
    // $page_data['page_title'] = get_phrase('Expense');
    // $this->load->view('backend/index', $page_data);

      
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['description']         =   $this->input->post('description');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = 'Expenses';
        $this->load->view('backend/index', $page_data); 
}


    

    function get_students_by_class($param1 = '' , $param2 = ''){
           $rr =  getStudentNames($param1);
	       echo json_encode($rr);
    }

    function ggetFeeByClassid($param1 = '' , $param2 = ''){
           $rr =  getFeeByClassid($param1);
	       echo json_encode($rr);
    }



     function fee($param1 = '' , $param2 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect('login', 'refresh');
        if ($param1 == 'create') {

            $data['fee_name']   =   $this->input->post('class_id');
            $data['monthly']   =   $this->input->post('monthly');
            $data['admission']   =   $this->input->post('admission');
            $data['examination']   =   $this->input->post('examination');
            
            $this->db->insert('fee' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/fee');
        }
        if ($param1 == 'edit') {
            $data['fee_name']   =   $this->input->post('class_id');
            $data['monthly']   =   $this->input->post('monthly');
            $data['admission']   =   $this->input->post('admission');
            $data['examination']   =   $this->input->post('examination');

            $this->db->where('fee_id' , $param2);
            $this->db->update('fee' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/fee');
        }
        if ($param1 == 'delete') {
            $this->db->where('fee_id' , $param2);
            $this->db->delete('fee');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/fee');
        }

        $page_data['page_name']  = 'fee';
        $page_data['page_title'] = 'Fee';
        $this->load->view('backend/index', $page_data);
    }

    function invoice_fee($param1 = '', $param2 = '', $param3 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['fee_date'] = $this->input->post('date');
            $data['title']              = $this->input->post('title');
            $data['class_id']         = $this->input->post('class_id');
            $data['student_id']         = $this->input->post('student_id');
            $data['fee_duration']         = $this->input->post('fee_duration');
            $data['amount']             = $this->input->post('amount');
            $data['transportation_fee'] = $this->input->post('transportation_amount');
            $data['examination_fee'] = $this->input->post('examination_amount');
            $data['admission_fee'] = $this->input->post('admission_amount');
            $data['other_fee_text'] = $this->input->post('other_fee_title');
            $data['other_fee'] = $this->input->post('other_fee_amount');
            $data['status']             = $this->input->post('status');
            $data['payment_method']             = $this->input->post('method');
            $data['description']        = $this->input->post('description');

            $data['amount_paid']        = $this->input->post('amount');
            $data['due']                = $data['amount'];
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();
 

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
            $this->db->insert('payment' , $data);

            $data2['amount_paid']   =   $this->input->post('amount');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');

            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/invoice', 'refresh');
        }
        $page_data['page_name']  = 'invoice_fee';
        $page_data['page_title'] = 'Manage Invoice/Payment';
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }


    function expense_category($param1 = '' , $param2 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }

        $page_data['page_name']  = 'expense_category';
        $page_data['page_title'] = 'Expense Category';
        $this->load->view('backend/index', $page_data);
    }

         
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        // if ($_SESSION['admin_login'] != 1)
        //     redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            
            $this->db->where('admin_id', $_SESSION['admin_id']);
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $_SESSION['admin_id'] . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('admin', array(
                'admin_id' => $_SESSION['admin_id']
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('admin_id', $_SESSION['admin_id']);
                $this->db->update('admin', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = 'Manage Profile';
        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'admin_id' => $_SESSION['admin_id']
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
}