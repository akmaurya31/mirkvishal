<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/expense_add/');" 
class="btn btn-primary pull-right"> 
    <i class="entypo-plus-circled"></i> <?php echo ('Add new expense');?>
</a> 
<br><br> 

<?php 
$curMonthYear = date("Y-m"); // YYYY-MM format
?> 

<div class="row mb-3"> 
  <div class="col-md-3"> 
    <label>From (Month-Year)</label> 
    <input type="month" id="from_date" class="form-control" value="<?php echo $curMonthYear; ?>"> 
  </div> 
  <div class="col-md-3"> 
    <label>To (Month-Year)</label> 
    <input type="month" id="to_date" class="form-control" value="<?php echo $curMonthYear; ?>"> 
  </div> 
  <div class="col-md-3 d-flex align-items-end"> 
    <button id="applyFilter" class="btn btn-success"> 
      <i class="entypo-search"></i> Apply Filter 
    </button> 
  </div> 
</div> 
<br>

<table class="table table-bordered table-hover table-striped datatable" id="table_export"> 
    <thead> 
        <tr> 
            <th>#</th> 
            <th><?php echo ('Title');?></th> 
            <th><?php echo ('Category');?></th> 
            <th><?php echo ('Method');?></th> 
            <th><?php echo ('Amount');?></th> 
            <th><?php echo ('Date');?></th> 
            <th><?php echo ('Options');?></th> 
        </tr> 
    </thead> 
    <tbody id="expenseBody">
        <?php $this->load->view('backend/admin/expense_body'); ?> 
    </tbody>
    <tfoot> 
        <tr>
            <td></td> 
            <td></td> 
            <td></td> 
            <th>Total</th> 
            <th id="totalAmount"><?php echo $this->expense_model->get_total_expense(); ?></th> 
            <td></td> 
            <td></td> 
        </tr>
    </tfoot> 
</table>

<script>
$(document).ready(function(){
    $('#applyFilter').click(function() {
        var from_date = $('#from_date').val();
        var to_date   = $('#to_date').val();
		 $('#expenseBody').html('');
         $('#totalAmount').html('');

        $.ajax({
            url: "<?php echo base_url();?>index.php?admin/expense/filter",
            type: "POST",
            data: { from_date: from_date, to_date: to_date },
            success: function(response) {
               var res = JSON.parse(response);
            //    console.log(res,"fff");
                $('#expenseBody').html(res.html);
                // $('#expenseBody').html("<tr><td>1</td><td>2bbbb</td><td>3bbbb</td><td>4</td><td>5</td><td>6</td><td>7</td></tr>");
                $('#totalAmount').html(res.total);
            }
        });
    });
});
</script>
