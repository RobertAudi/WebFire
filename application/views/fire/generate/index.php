<h2>Welcome to WebFire</h2>
<section id="welcome">
    <p>WebFire is a stand-alone version of <a href="https://github.com/AzizLight/fire">fire</a>. It lets the user generate controllers, models, views and migrations from any web browser.</p>
    <h3>Start generating!</h3>
    <ul id="generation-buttons">
        <li><?php echo anchor('fire/generate/controller', 'Controller', array('title' => 'Generate a controller', 'class' => 'button')); ?></li>
        <li><?php echo anchor('fire/generate/model', 'Model', array('title' => 'Generate a model', 'class' => 'button')); ?></li>
        <li><?php echo anchor('fire/generate/migration', 'Migration', array('title' => 'Generate a migration', 'class' => 'button')); ?></li>
    </ul>
</section>
