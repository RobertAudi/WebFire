<h2>New Model</h2>

<?php echo form_open('fire/generate/model'); ?>
    <p>
        <?php echo form_label('Model name:', 'name'); ?>
        <?php echo form_input('name', set_value('name', '')); ?>
        <?php echo form_error('name', '<span class="validation-error">', '</span>'); ?>
    </p>

    <p>
        <?php echo form_label('Parent model:', 'parent_class') ?>
        <?php echo form_input('parent_class', set_value('parent_class', 'CI_Model')) ?>
        <?php echo form_error('parent_class', '<span class="validation-error">', '</span>'); ?>
    </p>

    <p>
        <?php echo form_label('Subfolder:', 'subfolder'); ?>
        <?php echo form_input('subfolder', set_value('subfolder', '')); ?>
        <?php echo form_error('subfolder', '<span class="validation-error">', '</span>'); ?>
    </p>

    <?php $columns = $this->input->post('columns'); ?>
    <?php $types = $this->input->post('types'); ?>
    <?php $valid_types = array('varchar' => 'VARCHAR',
                               'text'    => 'TEXT',
                               'char'    => 'CHAR',
                               'int'     => 'INT',
                               'decimal' => 'DECIMAL',
                               'date'    => 'DATE',
                               'datetime' => 'DATETIME'); ?>
    <div id="table-columns">
        <h3>Columns:</h3>
    <?php if (!empty($columns) && !empty($types)): ?>
        <?php foreach ($columns as $index => $value): ?>
            <p>
                <?php echo form_input('columns[]', $value); ?>
                <?php echo form_dropdown('types[]', $valid_types, $types[$index]); ?>
                <?php if ($index >= 1): ?>
                    <a href="#" class="remove-table-column">Remove</a>
                <?php endif; ?>
                <?php echo form_error('columns[]', '<span class="validation-error">', '</span>'); ?>
            </p>
        <?php endforeach; ?>
    <?php else: ?>
            <p>
                <?php echo form_input('columns[]', ''); ?>
                <?php echo form_dropdown('types[]', $valid_types); ?>
            </p>
    <?php endif; ?>
    </div>
    <p><a href="#" id="add-table-column">Add column</a></p>

    <p>
        <?php echo form_label('Generate Migration?', 'migration'); ?>
        <?php $tmp = $this->input->post('migration'); ?>
        <?php $checked = (!empty($tmp)); ?>
        <?php $args = array('name' => 'migration',
                            'id' => 'generate-migration-checkbox',
                            'value' => 'generate',
                            'checked' => $checked); ?>
        <?php echo form_checkbox($args); ?>
    </p>

    <?php if ($checked): ?>
        <p id="parent-migration-container">
            <?php echo form_label('Parent Migration:', 'parent_migration'); ?>
            <?php echo form_input('parent_migration', $this->input->post('parent_migration')); ?>
        </p>
    <?php endif; ?>

    <p><?php echo form_submit('submit', 'Create model'); ?></p>
<?php echo form_close(); ?>
