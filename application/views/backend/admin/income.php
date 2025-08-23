 

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

	<button id="downloadExcel" class="btn btn-primary"> 
		<i class="entypo-download"></i> Download CSV 
	</button>

  </div> 
</div> 
<br>

<table class="table table-bordered table-hover table-striped datatable" id="table_export"> 
    <thead> 
        <tr> 
			<th><div>#</div></th>
            <th><div><?php echo ('Title');?></div></th>
            <th><div><?php echo ('Description');?></div></th>
            <th><div><?php echo ('Student Class');?></div></th>
            <th><div><?php echo ('Method');?></div></th>
            <th><div><?php echo ('Amount');?></div></th>
            <th><div><?php echo ('Date');?></div></th>
        </tr> 
    </thead> 
    <tbody id="incomeBody">
        <?php $this->load->view('backend/admin/income_body'); ?> 
    </tbody>
    <tfoot> 
        <tr>
            <td></td> 
            <td></td> 
            <td></td> 
            <th>Total</th> 
            <th id="totalAmount"><?php echo $this->expense_model->get_total_income(); ?></th> 
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
		 $('#incomeBody').html('');
         $('#totalAmount').html('');

        $.ajax({
            url: "<?php echo base_url();?>index.php?admin/income/filter",
            type: "POST",
            data: { from_date: from_date, to_date: to_date },
            success: function(response) {
               var res = JSON.parse(response);
            //    console.log(res,"fff");
                $('#incomeBody').html(res.html);
                // $('#incomeBody').html("<tr><td>1</td><td>2bbbb</td><td>3bbbb</td><td>4</td><td>5</td><td>6</td><td>7</td></tr>");
                $('#totalAmount').html(res.total);
            }
        });
    });


	 $('#downloadExcel').click(function() {
        let from_date = $('#from_date').val();
        let to_date   = $('#to_date').val();

        window.location.href = "<?php echo base_url('index.php?admin/income_export_csv'); ?>/from_date/" + from_date + "/to_date/" + to_date;
    });
});
</script>
