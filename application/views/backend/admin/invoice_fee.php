<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo ('Invoice/Payment List');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo ('Add Invoice/Payment');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table  class="table table-bordered table-hover table-striped datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div><?php echo ('Student');?></div></th>
                    		<th><div><?php echo ('Title');?></div></th>
                            <th><div><?php echo ('Total');?></div></th>
                            <th><div><?php echo ('Paid');?></div></th>
                    		<th><div><?php echo ('Status');?></div></th>
                    		<th><div><?php echo ('Date');?></div></th>
                    		<th><div><?php echo ('Options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php foreach($invoices as $row):?>
                        <tr>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['amount'];?></td>
                            <td><?php echo $row['amount_paid'];?></td>
							<td>
								<span class="label label-<?php if($row['status']=='paid')echo 'success';else echo 'secondary';?>"><?php echo $row['status'];?></span>
							</td>
							<td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <?php if ($row['due'] != 0):?>

                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_take_payment/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo ('Take Payment');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <?php endif;?>
                                    
                                    <!-- VIEWING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_view_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo ('View Invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_invoice/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo ('Edit');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>

                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/invoice/delete/<?php echo $row['invoice_id'];?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo ('Delete');?>
                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
            <?php echo form_open(base_url() . 'index.php?admin/invoice_fee/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default panel-shadow" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo ('Invoice Informations');?></div>
                            </div>
                            <div class="panel-body">

                            <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Date');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="datepicker form-control" name="date"/>
                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Title');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="title" placeholder="Monthly Fees - Feb"/>
                                    </div>
                                </div>

                             <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo ('Class');?></label>
                                <div class="col-sm-5">
                                    
                                    <select name="class_id" class="form-control" style="width:100%;" onchange="get_students_by_class(this.value)">
                                    	<?php 
										$teachers = $this->db->get('class')->result_array();
										foreach($teachers as $row):
										?>
                                    		<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo ('Student'); ?></label>
                                <div class="col-sm-9">
                                    <select name="student_id" class="form-control" id="student_dropdown">
                                        <option value=""><?php echo ('Select Student'); ?></option>
                                    </select>
                                </div>
                            </div>
                                
                           <?php /*     <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Student');?></label>
                                    <div class="col-sm-9">
                                        <select name="student_id" class="form-control" style="" >
                                            <?php 
                                            $this->db->order_by('class_id','asc');
                                            $students = $this->db->get('student')->result_array();
                                            foreach($students as $row):
                                            ?>
                                                <option value="<?php echo $row['student_id'];?>">
                                                    class <?php echo $this->crud_model->get_class_name($row['class_id']);?> -
                                                    roll <?php echo $row['roll'];?> -
                                                    <?php echo $row['name'];?>
                                                </option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>  */ ?>

	

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Fee Type');?></label>
                                    <div class="col-sm-9">
                                        <select name="fee_duration" class="form-control" id="id_fee_duration">
                                            <option value="1"><?php echo ('Monthly');?></option>
                                            <option value="4"><?php echo ('Quarterly');?></option>
                                            <option value="6"><?php echo ('Half-yearly');?></option>
                                            <option value="12"><?php echo ('Annually');?></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Amount');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control tcls" name="amount"  id="id_amount" />
                                        <input type="hidden" class="form-control" name="hid_amount"  id="id_hid_amount" />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Fees'); ?></label>
                                    <div class="col-sm-9">

                                        <div class="row mb-4">
                                            <div class="col-sm-6">
                                                <div class="checkbox">
                                                    <label>
                                                        <!-- <input type="checkbox" name="fee_type[]" value="transportation"> -->
                                                        <?php echo ('Transportation Fee'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mt-4">
                                                <input type="text" class="form-control tcls" name="transportation_amount" placeholder="Amount">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-sm-6">
                                                <div class="checkbox">
                                                    <label>
                                                        <!-- <input type="checkbox" name="fee_type[]" value="examination"> -->
                                                        <?php echo ('Examination Fee'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mt-4">
                                                <input type="text" class="form-control tcls" name="examination_amount" placeholder="Amount">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="checkbox">
                                                    <label>
                                                        <!-- <input type="checkbox" name="fee_type[]" value="admission"> -->
                                                        <?php echo ('Admission Fee'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control tcls" name="admission_amount"  id="id_admission_amount" placeholder="Amount">
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Other Fee'); ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="other_fee_title" placeholder="Fee Title (e.g., Sports Fee)" />
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control tcls" name="other_fee_amount" placeholder="Amount" />
                                    </div>
                                </div>


                              

                                 <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Total');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="tot_amount" id="id_tot_amount"
                                            placeholder="<?php echo ('Enter Total Amount');?>" value="0"/>
                                    </div>
                                </div>



                                  <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Status');?></label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control">
                                            <option value="paid"><?php echo ('Paid');?></option>
                                            <option value="unpaid"><?php echo ('Unpaid');?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Method');?></label>
                                    <div class="col-sm-9">
                                        <select name="method" class="form-control">
                                            <option value="1"><?php echo ('Cash');?></option>
                                            <option value="2"><?php echo ('Cheque');?></option>
                                            <option value="3"><?php echo ('Card');?></option>
                                        </select>
                                    </div>
                                </div>
                                


                            <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo ('Comment');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="description"/>
                                    </div>
                                </div>


                                

                                  <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo ('Add Invoice');?></button>
                            </div>
                        </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                   
                </div>
            <?php echo form_close();?>
			</div>
			<!----CREATION FORM ENDS-->
            
		</div>
	</div>
</div>


<script>
 function get_students_by_class(class_id) {
    if (class_id != "") {
        // 1. Get students list
        $.ajax({
            url: "<?php echo base_url(); ?>index.php?admin/get_students_by_class/" + class_id,
            success: function(response) {
                var options = '<option value="">Select Student</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                $('#student_dropdown').html(options);
            }
        });

        // 2. Get fee details, then calculate total
        $.ajax({
            url: "<?php echo base_url(); ?>index.php?admin/ggetFeeByClassid/" + class_id,
            success: function(response1) {
                var response = JSON.parse(response1);

                if (response.length > 0) {
                    $('#id_amount').val(response[0].monthly);
                    $('#id_hid_amount').val(response[0].monthly);
                    $('#id_admission_amount').val(response[0].admission);
                } else {
                    $('#id_amount').val('');
                    $('#id_hid_amount').val('');
                    $('#id_admission_amount').val('');
                }

                // ✅ 3. Calculate total only after fee data is set
                calcu();
            }
        });

    } else {
        $('#student_dropdown').html('<option value="">Select Student</option>');
    }
}





function totalAmount(){

   var id_amount= $('#id_amount').val();
//    alert(id_amount);
}

 totalAmount();

    $('.tcls').on('change keyup', function() {
      calcu();
    });


    $('input[name="fee_type[]"]').on('change', function() {
        let selectedFees = [];

        $('input[name="fee_type[]"]:checked').each(function() {
            selectedFees.push($(this).val());
        });
    });



$(document).ready(function() {
    $('#id_fee_duration').on('change', function() {
         calcu();
    });
});


    
function calcu(){
        let monthlyFee = parseFloat($('#id_hid_amount').val()) || 0; // get base monthly fee
        var feee= $('#id_fee_duration').val();
        let duration = parseInt(feee) || 1; // duration selected
        let totalFee = monthlyFee * duration;
        $('#id_amount').val(totalFee.toFixed(2)); // set calculated total
        

        var total = 0;
        $('.tcls').each(function() {
            var val = parseFloat($(this).val()) || 0;
            total += val;
        });



        $('#id_tot_amount').val(total.toFixed(2));
}

// $('#fee_type').val()

 


</script>
