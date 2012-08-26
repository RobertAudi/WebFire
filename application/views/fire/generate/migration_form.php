<h2>New Migration</h2>

<?php echo form_open('fire/generate/migration'); ?>
    <p>
        <?php echo form_label('Migration name:', 'name'); ?>
        <?php echo form_input('name', set_value('name', '')); ?>
        <?php echo form_error('name', '<span class="validation-error">', '</span>'); ?>
    </p>

    <p>
        <?php echo form_label('Parent migration:', 'parent_class') ?>
        <?php echo form_input('parent_class', set_value('parent_class', 'CI_Migration')) ?>
        <?php echo form_error('parent_class', '<span class="validation-error">', '</span>'); ?>
    </p>

    <p><?php echo form_submit('submit', 'Create Migration'); ?></p>
<?php echo form_close(); ?>
