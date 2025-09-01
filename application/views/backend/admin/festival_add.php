<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo ('Add Festival');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/festival/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
				 


					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo ('Festival');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="festival_name" data-validate="required" data-message-required="<?php echo ('Value Required');?>" value="" autofocus>

						</div>
					</div>
					
					

					
					
					
				
					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo ('decoration');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="decoration_charge" data-validate="required" data-message-required="<?php echo ('Value Required');?>" value="" autofocus>

						</div>
					</div>

					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo ('prize');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="prize" data-validate="required" data-message-required="<?php echo ('Value Required');?>" value="" autofocus>

						</div>
					</div>



					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo ('sweets');?></label>
                        <div class="col-sm-6">
							<input type="text" class="form-control" name="sweets" data-validate="required" data-message-required="<?php echo ('Value Required');?>" value="" autofocus>
						</div>
						</div>

                     	
						<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo ('tour');?></label>
                        <div class="col-sm-6">
							<input type="text" class="form-control" name="tour" data-validate="required" data-message-required="<?php echo ('Value Required');?>" value="" autofocus>
						</div>
						</div>

   
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo ('Add Festival');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>