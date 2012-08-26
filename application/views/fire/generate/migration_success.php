<h2>Success!</h3>
<?php if (isset($success)): ?>
    <?php $message = ' and the migration number was added to the migration configuration file'; ?>
<?php else: ?>
    <?php $message = ''; ?>
<?php endif; ?>
<p class="confirmation-message">The <?php echo $migration; ?> migration was successfully created<?php echo $message; ?>!</p>
<div id="files">
    <ul>
        <li><span class="file-created">Created:</span> <?php echo $files_created['migration']; ?></li>
        <?php if (isset($edited_migration_config)): ?>
            <li><span class="file-edited">Edited:</span> <?php echo $edited_migration_config; ?></li>
        <?php elseif (isset($not_edited_migration_config)): ?>
            <li><span class="file-not-edited">Not edited:</span> <?php echo $not_edited_migration_config; ?></li>
        <?php endif; ?>
    </ul>
</div>
