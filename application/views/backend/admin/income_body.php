<?php 
$count = 1;
$srr = [];
$this->db->where('payment_type', 'income');
$this->db->where('MONTH(FROM_UNIXTIME(timestamp))', date('m'));
$this->db->where('YEAR(FROM_UNIXTIME(timestamp))', date('Y'));
$this->db->order_by('timestamp', 'desc');
$expenses = $this->db->get('payment')->result_array();

foreach ($expenses as $row): 
?>
<tr> 
    <td><?php echo $count++;?></td> 
    <td><?php echo $row['title'];?></td> 

    <td> 
        <?php echo $row['description'];?> </td> 

       <td>    <?php echo $this->expense_model->getStudent($row['student_id']); ?> </td> 
        <?php 
        // if (!empty($row['expense_category_id'])) {
        //     $cat = $this->db->get_where('expense_category' , ['expense_category_id' => $row['expense_category_id']])->row();
        //     echo $cat ? $cat->name : '';
        // }
        ?> 
    </td> 
    <td> 
        <?php 
        if ($row['method'] == 1) echo ('Cash'); 
        if ($row['method'] == 2) echo ('Cheque'); 
        if ($row['method'] == 3) echo ('Card'); 
        ?> 
    </td> 
    <td><?php echo $srr[] = $row['amount'];?></td> 
    <td><?php echo date('d M,Y', $row['timestamp']);?></td> 
    
</tr> 
<?php endforeach; ?>
