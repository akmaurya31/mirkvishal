<?php 
$count = 1;
$srr = [];
$this->db->where('payment_type' , 'expense'); 
$this->db->order_by('timestamp' , 'desc'); 
$expenses = $this->db->get('payment')->result_array(); 

foreach ($expenses as $row): 
?>
<tr> 
    <td><?php echo $count++;?></td> 
    <td><?php echo $row['title'];?></td> 
    <td> 
        <?php 
        if (!empty($row['expense_category_id'])) {
            $cat = $this->db->get_where('expense_category' , ['expense_category_id' => $row['expense_category_id']])->row();
            echo $cat ? $cat->name : '';
        }
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
    <td> 
        <div class="btn-group"> 
            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"> 
                Action <span class="caret"></span> 
            </button> 
            <ul class="dropdown-menu dropdown-default pull-right" role="menu"> 
                <li> 
                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_slip/<?php echo $row['payment_id'];?>');"> 
                        <i class="entypo-credit-card"></i> <?php echo ('Slip');?> 
                    </a> 
                </li> 
                <li class="divider"></li> 
                <li> 
                    <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/expense_edit/<?php echo $row['payment_id'];?>');"> 
                        <i class="entypo-pencil"></i> <?php echo ('Edit');?> 
                    </a> 
                </li> 
                <li class="divider"></li> 
                <li> 
                    <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/expense/delete/<?php echo $row['payment_id'];?>');"> 
                        <i class="entypo-trash"></i> <?php echo ('Delete');?> 
                    </a> 
                </li> 
            </ul> 
        </div> 
    </td> 
</tr> 
<?php endforeach; ?>
