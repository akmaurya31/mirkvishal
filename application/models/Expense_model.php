<?php class Expense_model extends CI_Model {
    public function get_total_expense() {
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'expense');
        $res = $this->db->get('payment')->row();
        return $res ? $res->amount : 0;
    }
}
