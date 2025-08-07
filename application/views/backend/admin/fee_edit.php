<?php 
    $edit_data = $this->db->get_where('fee', array(
        'fee_id' => $param2
    ))->result_array();

    foreach ($edit_data as $row):
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-plus-circled"></i>
                    <?php echo ('Edit Fee'); ?>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?admin/fee/edit/' . $row['fee_id'], array(
                    'class' => 'form-horizontal form-groups-bordered validate',
                    'enctype' => 'multipart/form-data'
                )); ?>

            
<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo ('Class'); ?></label>
    <div class="col-sm-5">
        <select name="class_id" class="form-control" style="width:100%;">
            <?php 
            $classes = $this->db->get('class')->result_array();
            foreach ($classes as $class):
                // Check if class_id matches the value you're trying to preselect
                $selected = ($class['class_id'] == $row['fee_name']) ? 'selected' : '';
            ?>
                <option value="<?php echo $class['class_id']; ?>" <?php echo $selected; ?>>
                    <?php echo $class['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

               

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Monthly'); ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="monthly"
                            data-validate="required" data-message-required="<?php echo ('Value Required'); ?>"
                            value="<?php echo $row['monthly']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Admission'); ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="admission"
                            data-validate="required" data-message-required="<?php echo ('Value Required'); ?>"
                            value="<?php echo $row['admission']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo ('Examination'); ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="examination"
                            data-validate="required" data-message-required="<?php echo ('Value Required'); ?>"
                            value="<?php echo $row['examination']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo ('Update Fee'); ?></button>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>
