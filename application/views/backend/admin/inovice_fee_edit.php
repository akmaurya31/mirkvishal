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
                    <label class="col-sm-3 control-label"><?php echo ('Fee Name'); ?></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="fee_name"
                            data-validate="required" data-message-required="<?php echo ('Value Required'); ?>"
                            value="<?php echo $row['fee_name']; ?>" autofocus>
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
