<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo ('Addmission Form');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo ('Name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo ('Value Required');?>" value="" autofocus>
						</div>
					</div>


					<div class="form-group">
						<label for="field-father" class="col-sm-3 control-label"><?php echo ('Father Name'); ?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="father_name" data-validate="required" data-message-required="<?php echo ('Value Required'); ?>" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-mother" class="col-sm-3 control-label"><?php echo ('Mother Name'); ?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="mother_name" data-validate="required" data-message-required="<?php echo ('Value Required'); ?>" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-graduation" class="col-sm-3 control-label"><?php echo ('Guardian Name'); ?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="graduation_name" data-validate="required" data-message-required="<?php echo ('Value Required'); ?>" value="">
						</div>
					</div>

					 
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Class');?></label>
                        
						<div class="col-sm-5">
							<select name="class_id" class="form-control" data-validate="required" id="class_id" 
								data-message-required="<?php echo ('Value Required');?>"
									onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo ('Select');?></option>
                              <?php 
								$classes = $this->db->get('class')->result_array();
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['class_id'];?>">
											<?php echo $row['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Section');?></label>
		                    <div class="col-sm-5">
		                        <select name="section_id" class="form-control" id="section_selector_holder">
		                            <option value=""><?php echo ('Select class first');?></option>
			                        
			                    </select>
			                </div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Roll');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="roll" value="" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" value="" data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control">
                              <option value=""><?php echo ('Select');?></option>
                              <option value="Male"><?php echo ('Male');?></option>
                              <option value="Female"><?php echo ('Female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Address');?></label>
                        
						<div class="col-sm-5">
							<textarea class="form-control" name="address" rows="4"></textarea>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="" >
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Adhar Number</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="adharcard"  value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Guardian Adhar Number</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="grd_adharcard"  value="">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo (' Admission Date');?></label>
						<div class="col-sm-9">
							<input type="text" class="datepicker form-control" name="add_date"/>
						</div>
					</div>

                    
					<div class="form-group" style="display:none" >
						<label for="field-1" class="col-sm-3 control-label"><?php echo ('Email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" id="emailField" value="">
						</div>
					</div>
					
					<div class="form-group" style="display:none" >
						<label for="field-2" class="col-sm-3 control-label"><?php echo ('Password');?></label>
                        
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" value="Student@2121" >
						</div> 
					</div>
	
					<!-- <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo ('Photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div> -->
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo ('Add Student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


<script>
function setRandomEmail() {
    const emailField = document.getElementById('emailField');

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const dateStr = `${yyyy}${mm}${dd}`;

    const randomNum = Math.floor(Math.random() * 1000);

    const email = `user${randomNum}_${dateStr}@example.com`;
    emailField.value = email;
}

// Automatically run on page load
window.onload = setRandomEmail;
</script>


<script type="text/javascript">

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

</script>