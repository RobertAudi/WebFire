<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Fire: CodeIgniter Code Generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/fire.css'); ?>" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="<?php echo base_url('assets/js/fire.js'); ?>" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <header class="clearfix">
            <h1>WebFire</h1>
            <nav>
                <ul>
                    <li><?php echo anchor('fire/generate/controller', 'Controller'); ?></li>
                    <li><?php echo anchor('fire/generate/model', 'Model'); ?></li>
                    <li><?php echo anchor('fire/generate/migration', 'Migration'); ?></li>
                </ul>
            </nav>
        </header>

        <div id="wrapper">

            <?php foreach (array('success', 'notice', 'error') as $flash): ?>
                <?php if (isset(${$flash})): ?>
                    <p class="<?php echo $flash; ?>"><?php echo ${$flash}; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php $this->load->view($view); ?>

        </div>
    </body>
</html>
