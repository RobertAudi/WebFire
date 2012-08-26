<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate
 */
class Generate_model
{
    /**
     * El Contructor!
     */
    public function __construct()
    {
        $ci = get_instance();
        $ci->load->helper('file');
    }

    public function controller(array $location, $controller)
    {
        if (!is_dir($location['folder']))
        {
            mkdir($location['folder'], 0755, TRUE);
        }

        return write_file($location['folder'] . $location['filename'], $controller);
    }

    public function views($controller, $actions, $subfolder = '')
    {
        if (!is_dir(APPPATH . 'views/' . $subfolder . strtolower($controller)))
        {
            mkdir(APPPATH . 'views/' . $subfolder . strtolower($controller), 0755, TRUE);
        }

        $result = FALSE;

        $tmp = explode('/', trim(APPPATH, '/'));
        $application_folder = end($tmp);

        foreach ($actions as $action)
        {
            $content = '<h1>' . $controller . '#' . $action . '</h1>';
            $partial_relative_path = $subfolder . strtolower($controller) . '/' . $action . '.php';
            $relative_path = $application_folder . '/' . $partial_relative_path;
            $location = APPPATH . 'views/' . $partial_relative_path;
            $content .= PHP_EOL . '<p>Find me in ' . $relative_path . '</p>';
            $result = write_file($location, $content);
            unset($content, $location, $partial_relative_path, $relative_path);
        }

        return $result;
    }

    public function model(array $location, $model)
    {
        if (!is_dir($location['folder']))
        {
            mkdir($location['folder'], 0755, TRUE);
        }

        return write_file($location['folder'] . $location['filename'], $model);
    }

    public function migration(array $location, $migration)
    {
        if (!is_dir($location['folder']))
        {
            mkdir($location['folder'], 0755, TRUE);
        }

        return write_file($location['folder'] . $location['filename'], $migration);
    }
} // End of the Generate

/* End of file generate_model.php */
/* Location application/models/fire/generate_model.php */
