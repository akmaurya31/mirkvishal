
<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/fee_add/');" 
class="btn btn-primary pull-right">
<i class="entypo-plus-circled"></i>
<?php echo ('Add new Fee');?>
</a> 
<br><br>
<table class="table table-bordered table-hover table-striped datatable" id="table_export">
    <thead>
        <tr>
            <th><div>#</div></th>
            <!-- <th><div><?php echo ('Fee Name');?></div></th> -->
            <th><div><?php echo ('Class Name');?></div></th>
            <th><div><?php echo ('Monthly');?></th>
            <th><div><?php echo ('Admission');?></div></th>
            <th><div><?php echo ('Examination');?></div></th>
            <th><div><?php echo ('Action');?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        	$count = 1;
        	$expenses = $this->db->get('fee')->result_array();
        	foreach ($expenses as $row):
        ?>
        <tr>
            <td><?php echo $count++;?></td>
            <!-- <td><?php // echo $row['fee_name'];?></td> -->

            <td><?php  echo getClassName($row['fee_name']);  //echo  ?></td>
            <td><?php echo $row['monthly'];?></td>
            <td><?php echo $row['admission'];?></td>
            <td><?php echo $row['examination'];?></td>
            <td>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                        
                        <!-- teacher EDITING LINK -->
                        <li>
                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/fee_edit/<?php echo $row['fee_id'];?>');">
                            	<i class="entypo-pencil"></i>
									<?php echo ('Edit');?>
                               	</a>
                        				</li>
                        <li class="divider"></li>
                        
                        <!-- teacher DELETION LINK -->
                        <li>
                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/fee/delete/<?php echo $row['fee_id'];?>');">
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



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [
					
					{
						"sExtends": "xls",
						"mColumns": [1,2,3,4,5]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1,2,3,4,5]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(2, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(2, true);
								  }
							});
						},
						
					},
				]
			},
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

