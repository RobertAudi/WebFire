<h2>Success!</h2>
<p class="confirmation-message">The <?php echo $controller; ?> controller was successfully created!</p>
<div id="files">
    <ul>
        <li><span class="file-created">Created:</span> <?php echo $files_created['controller']; ?></li>
        <?php if (isset($files_created['views']) && !empty($files_created['views'])): ?>
            <?php foreach ($files_created['views'] as $view): ?>
                <li><span class="file-created">Created:</span> <?php echo $view; ?></li>
            <?php endforeach; ?>
        <?php elseif (isset($files_not_created['views']) && !empty($files_not_created['views'])): ?>
            <?php foreach ($files_not_created['views'] as $view): ?>
                <li><span class="file-not-created">Not created:</span> <?php echo $view; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
