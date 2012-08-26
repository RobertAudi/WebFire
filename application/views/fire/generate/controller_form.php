<h2>New Controller</h2>
<?php echo form_open('fire/generate/controller'); ?>
    <p>
        <?php echo form_label('Controller name:', 'name'); ?>
        <?php echo form_input('name', set_value('name', '')); ?>
        <?php echo form_error('name', '<span class="validation-error">', '</span>'); ?>
    </p>

    <p>
        <?php echo form_label('Parent controller:', 'parent_class') ?>
        <?php echo form_input('parent_class', set_value('parent_class', 'CI_Controller')) ?>
        <?php echo form_error('parent_class', '<span class="validation-error">', '</span>'); ?>
    </p>

    <p>
        <?php echo form_label('Subfolder:', 'subfolder'); ?>
        <?php echo form_input('subfolder', set_value('subfolder', '')); ?>
        <?php echo form_error('subfolder', '<span class="validation-error">', '</span>'); ?>
    </p>

    <div id="controller-actions">
        <h3>Actions</h3>
    <?php $actions = $this->input->post('actions'); ?>
    <?php if (!empty($actions)): ?>
        <?php foreach ($actions as $index => $action): ?>
        <p>
            <?php echo form_input('actions[]', $action); ?>
            <?php if ($index >= 1): ?>
                <a href="#" class="remove-controller-action">Remove</a>
            <?php endif; ?>
            <?php echo form_error('actions[]', '<span class="validation-error">', '</span>'); ?>
        </p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>
            <?php echo form_input('actions[]', ''); ?>
            <?php echo form_error('actions[]', '<span class="validation-error">', '</span>'); ?>
        </p>
    <?php endif; ?>
    </div>
    <p><a href="#" id="add-controller-action">Add action</a></p>

    <p>
        <?php $tmp = $this->input->post('views'); ?>
        <?php $checked = (!empty($tmp)); ?>
        <?php echo form_checkbox('views', 'generate', $checked); ?>
        <?php echo form_label('Generate Views?', 'views'); ?>
    </p>

    <p><?php echo form_submit('submit', 'Create controller'); ?></p>
<?php echo form_close(); ?>
