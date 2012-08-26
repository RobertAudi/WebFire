<h2>Success!</h2>
<p class="confirmation-message">The <?php echo $model; ?> model was successfully created!</p>
<div id="files">
    <ul>
        <li><span class="file-created">Created:</span> <?php echo $files_created['model']; ?></li>
        <?php if (isset($files_created['migration'])): ?>
            <li><span class="file-created">Created:</span> <?php echo $files_created['migration']; ?></li>
        <?php elseif (isset($files_not_created['migration'])): ?>
            <li><span class="file-not-created">Not created:</span> <?php echo $files_not_created['migration']; ?></li>
        <?php endif; ?>
        <?php if (isset($edited_migration_config)): ?>
            <li><span class="file-edited">Edited:</span> <?php echo $edited_migration_config; ?></li>
        <?php elseif (isset($not_edited_migration_config)): ?>
            <li><span class="file-not-edited">Not edited:</span> <?php echo $not_edited_migration_config; ?></li>
        <?php endif; ?>
    </ul>
</div>
