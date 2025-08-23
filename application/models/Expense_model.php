<?php class Expense_model extends CI_Model {
    public function get_total_expense() {
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'expense');
        $res = $this->db->get('payment')->row();
        return $res ? $res->amount : 0;
    }

    public function get_total_income() {
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'income');
        $res = $this->db->get('payment')->row();
        return $res ? $res->amount : 0;
    }

 public function getStudent($id) {
    $this->db->select("CONCAT(student.name, ' - ', class.name) AS full_name", FALSE);
    $this->db->from('student');
    $this->db->join('class', 'class.class_id = student.class_id', 'left');
    $this->db->where('student.student_id', $id);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->full_name;
    } else {
        echo "No student found!";
    }
}
 
}
