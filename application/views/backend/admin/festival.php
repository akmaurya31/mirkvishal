
<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/festival_add/');" 
class="btn btn-primary pull-right">
<i class="entypo-plus-circled"></i>
<?php echo ('Add new Festival');?>
</a> 
<br><br>
<table class="table table-bordered table-hover table-striped datatable" id="table_export">
    <thead>
        <tr>
            <th><div>#</div></th>
            <!-- <th><div><?php echo ('Festival_id');?></div></th> -->
            <th><div><?php echo ('festival_name');?></div></th>
            <th><div><?php echo ('sweets');?></th>
            <th><div><?php echo ('decoration_charge');?></div></th>
            <th><div><?php echo ('prize');?></div></th>
            <th><div><?php echo ('tour');?></div></th>
			<th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        	$count = 1;
        	$expenses = $this->db->get('festival')->result_array();
        	foreach ($expenses as $row):
        ?>
        <tr>
            <td><?php echo $count++;?></td>
            <!-- <td><?php // echo $row['fee_name'];?></td> -->

            <td><?php  echo $row['festival_name'];  //echo  ?></td>
            <td><?php echo $row['sweets'];?></td>
            <td><?php echo $row['decoration_charge'];?></td>
            <td><?php echo $row['prize'];?></td>
             <td><?php echo $row['tour'];?></td>
            <td>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                        
                        <!-- teacher EDITING LINK -->
                        <li>
                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/festival_edit/<?php echo $row['festival_id'];?>');">
                            	<i class="entypo-pencil"></i>
									<?php echo ('Edit');?>
                               	</a>
                        				</li>
                        <li class="divider"></li>
                        
                        <!-- teacher DELETION LINK -->
                        <li>
                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/festival/delete/<?php echo $row['festival_id'];?>');">
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

