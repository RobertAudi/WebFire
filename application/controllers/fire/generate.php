<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate
 */
class Generate extends CI_Controller
{

    /**
     * The Contructor!
     */
    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT == 'production') {
            show_404();
        }
        $this->load->model('fire/template_scanner');
        $this->load->model('fire/generate_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('inflector');
        $this->load->helper('url');
        $this->load->helper('fire/generate');
    }

    public function index()
    {
        $data = array('view' => 'fire/generate/index');
        $this->load->view('fire/layout.php', $data);
    }

    public function controller()
    {
        $data = array();

        $validation_rules = array(
            array(
                'field' => 'name',
                'label' => 'Controller name',
                'rules' => 'required|max_length[50]'
            ),
            array(
                'field' => 'parent_class',
                'label' => 'Parent controller',
                'rules' => 'required|max_length[50]'
            ),
            array(
                'field' => 'subfolder',
                'label' => 'Controller subfolder',
                'rules' => 'max_length[50]'
            ),
            array(
                'field' => 'actions[]',
                'label' => 'Controller action',
                'rules' => 'max_length[50]|callback_check_extra'
            ),
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run() === FALSE)
        {
            $data['view'] = 'fire/generate/controller_form';
        }
        else if (does_controller_exist($this->input->post()) === TRUE)
        {
            $data['notice'] = 'The ' . $this->input->post('name') . ' controller already exists!';
            $data['view'] = 'fire/generate/controller_form';
        }
        else
        {
            $tmp = explode('/', trim(APPPATH, '/'));
            $application_folder = end($tmp);
            unset($tmp);

            $parent_class = ($this->input->post('parent_class') === 'CI_Controller') ? 'CI_Controller' : camelize($this->input->post('parent_class'));
            $tmp = $this->input->post('subfolder');
            $subfolder = (empty($tmp)) ? '' : trim($this->input->post('subfolder'), '/') . '/';
            unset($tmp);

            $args = array(
                "class_name"         => ucfirst(camelize($this->input->post('name'))),
                "filename"           => strtolower($this->input->post('name')) . '.php',
                "application_folder" => $application_folder,
                "parent_class"       => $parent_class,
                "extra"              => $this->_generate_actions($this->input->post()),
                'relative_location'  => $application_folder . '/controllers/' . $subfolder . $this->input->post('name') . '.php'
            );

            $controller = $this->template_scanner->parse('controller', $args);

            $location = array( 'folder' => APPPATH . 'controllers/' . $subfolder, 'filename' => $args['filename'] );
            if ($this->generate_model->controller($location, $controller))
            {
                $data['controller'] = ucfirst(camelize($this->input->post('name')));
                $data['files_created'] = array();
                $data['files_created']['controller'] = $args['relative_location'];

                $tmp = $this->input->post('views');
                if (empty($tmp) || $this->generate_model->views($args['class_name'], $this->input->post('actions'), $subfolder))
                {
                    $data['files_created']['views'] = array();
                    foreach ($this->input->post('actions') as $action)
                    {
                        $data['files_created']['views'][] = $application_folder . '/views/' . $subfolder . strtolower($this->input->post('name')) . '/' . $action . '.php';
                    }
                    $data['success'] = 'The ' . $this->input->post('name') . ' controller was successfully created!';
                }
                else
                {
                    $data['files_not_created'] = array();
                    $data['files_not_created']['views'] = array();
                    foreach ($this->input->post('actions') as $action)
                    {
                        $data['files_not_created']['views'][] = $application_folder . '/views/' . $subfolder . strtolower($this->input->post('name')) . $action . '.php';
                    }

                    $data['notice'] = 'The ' . $this->input->post('name') . ' controller was successfully created, but the views couldn\'t be generated...';
                }
                $data['view'] = 'fire/generate/controller_success';
            }
            else
            {
                $data['error'] = 'Unable to create the ' . $this->input->post('name') . ' controller...';
                $data['view'] = 'fire/generate/controller_form';
            }
        }

        $this->load->view('fire/layout', $data);
    }

    public function model()
    {
        $data = array();

        $validation_rules = array(
            array(
                'field' => 'name',
                'label' => 'Model name',
                'rules' => 'required|max_length[50]'
            ),
            array(
                'field' => 'parent_class',
                'label' => 'Parent model',
                'rules' => 'required|max_length[50]'
            ),
            array(
                'field' => 'subfolder',
                'label' => 'Model subfolder',
                'rules' => 'max_length[50]'
            ),
            array(
                'field' => 'columns[]',
                'label' => 'Table column',
                'rules' => 'max_length[50]|callback_check_extra'
            ),
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run() === FALSE)
        {
            $data['view'] = 'fire/generate/model_form';
        }
        else if (does_model_exist($this->input->post()) === TRUE)
        {
            $data['notice'] = 'The ' . $this->input->post('name') . ' model already exists!';
            $data['view'] = 'fire/generate/model_form';
        }
        else
        {
            $tmp = explode('/', trim(APPPATH, '/'));
            $application_folder = end($tmp);
            unset($tmp);

            $parent_class = ($this->input->post('parent_class') === 'CI_Model') ? 'CI_Model' : camelize($this->input->post('parent_class'));
            $tmp = $this->input->post('subfolder');
            $subfolder = (empty($tmp)) ? '' : trim($this->input->post('subfolder'), '/') . '/';
            unset($tmp);

            $args = array(
                "class_name"         => ucfirst(camelize($this->input->post('name'))),
                "filename"           => strtolower($this->input->post('name')) . '.php',
                "application_folder" => $application_folder,
                "parent_class"       => $parent_class,
                'relative_location'  => $application_folder . '/model/' . $subfolder . $this->input->post('name') . '.php'
            );

            $model = $this->template_scanner->parse('model', $args);

            $location = array( 'folder' => APPPATH . 'models/' . $subfolder, 'filename' => $args['filename'] );
            if ($this->generate_model->model($location, $model))
            {
                $data['model'] = ucfirst(camelize($this->input->post('name')));
                $data['files_created'] = array();
                $data['files_created']['model'] = $args['relative_location'];

                $tmp = $this->input->post('migration');
                if (!empty($tmp))
                {
                    unset($tmp, $location);
                    $location = array( 'folder' => APPPATH . 'migrations/', 'filename' => $args['filename'] );
                    $tmp = $this->input->post('columns');
                    $tmpk = key($tmp);
                    if (count($tmp) === 1 && empty($tmpk))
                    {
                        $migration = $this->_generate_migration($location, $this->input->post(), TRUE);
                    }
                    else
                    {
                        $migration = $this->_generate_migration($location, $this->input->post());
                    }

                    if ($this->generate_model->migration($location, $migration))
                    {
                        $data['files_created']['migration'] = $application_folder . '/migrations/' . $location['filename'];

                        if (add_migration_number_to_config_file(get_latest_migration_number()))
                        {
                            $data['success'] = 'Successfully created the ' . $this->input->post('name') . ' model and its migration!';
                            $data['edited_migration_config'] = $application_folder . '/config/migration.php';
                        }
                        else
                        {
                            $data['not_edited_migration_config'] = $application_folder . '/config/migration.php';
                            $data['notice'] = 'The ' . $this->input->post('name') . ' model and its migration was successfully created but the migration configuration file was not edited...';
                        }
                    }
                    else
                    {
                        $filename = get_migration_number() . '_' . plural(underscore($params['name'])) . '.php';
                        $data['files_not_created'] = array();
                        $data['files_not_created']['migration'] = $application_folder . '/migrations/' . $filename;
                        $data['notice'] = 'The ' . $this->input->post('name') . ' was successfully created but its migration wasn\'t...';
                    }
                }
                else
                {
                    $data['success'] = 'Successfully created the ' . $this->input->post('name') . ' model!';
                }
                $data['view'] = 'fire/generate/model_success';
            }
            else
            {
                $data['error'] = 'Unable to create the ' . $this->input->post('name') . ' model...';
                $data['view'] = 'fire/generate/model_form';
            }
        }

        $this->load->view('fire/layout', $data);
    }

    public function migration()
    {
        $data = array();

        $validation_rules = array(
            array(
                'field' => 'name',
                'label' => 'Migration name',
                'rules' => 'required|max_length[150]'
            ),
            array(
                'field' => 'parent_class',
                'label' => 'Parent migration',
                'rules' => 'required|max_length[50]'
            )
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run() === FALSE)
        {
            $data['view'] = 'fire/generate/migration_form';
        }
        else if (does_migration_exist($this->input->post()) === TRUE)
        {
            $data['notice'] = 'The ' . $this->input->post('name') . ' migration already exists!';
            $data['view'] = 'fire/generate/migration_form';
        }
        else
        {
            $tmp = explode('/', trim(APPPATH, '/'));
            $application_folder = end($tmp);
            unset($tmp);

            $parent_class = ($this->input->post('parent_class') === 'CI_Migration') ? 'CI_Migration' : $this->input->post('parent_class');

            $args = array(
                "class_name"         => 'Migration_' . underscore($this->input->post('name')),
                "filename"           => get_migration_number() . '_' . underscore($this->input->post('name')) . '.php',
                "application_folder" => $application_folder,
                "parent_class"       => $parent_class,
                'relative_location'  => $application_folder . '/migrations/' . get_migration_number() . '_' . underscore($this->input->post('name')) . '.php'
            );

            $migration = $this->template_scanner->parse('empty_migration', $args);

            $location = array('folder' => APPPATH . 'migrations/', 'filename' => $args['filename']);
            if ($this->generate_model->migration($location, $migration))
            {
                $data['migration'] = $this->input->post('name');
                $data['files_created'] = array();
                $data['files_created']['migration'] = $args['relative_location'];

                if (add_migration_number_to_config_file(get_latest_migration_number()))
                {
                    $data['edited_migration_config'] = $application_folder . '/config/migration.php';
                    $data['success'] = 'Successfully created the ' . $this->input->post('name') . ' migration and edited the migration configuration file!';
                }
                else
                {
                    $data['not_edited_migration_config'] = $application_folder . '/config/migration.php';
                    $data['notice'] = 'The ' . $this->input->post('name') . ' migration was successfully created but the migration configuration file was not edited...';
                }
                $data['view'] = 'fire/generate/migration_success';
            }
            else
            {
                $data['error'] = 'Unable to create the ' . $this->input->post('name') . ' migration...';
                $data['view'] = 'fire/generate/migration_form';
            }
        }

        $this->load->view('fire/layout', $data);
    }

    private function _generate_actions(array $params)
    {
        if (empty($params['actions']))
        {
            return "";
        }

        $tmp = key($params['actions']);
        if (empty($tmp))
        {
            return "";
        }

        $extra = '';

        $actions = $params['actions'];
        foreach ($actions as $action)
        {
            $args = array(
                'class_name' => camelize($params['name']),
                'view_folder' => $params['subfolder'],
                'extra' => $action
            );

            if (!empty($params['subfolder']))
            {
                $args['subfolder'] = $params['subfolder'];
            }

            $extra .= $this->template_scanner->parse('action', $args);
        }

        return $extra;
    }

    private function _generate_migration(&$location, $params, $empty_migration = FALSE)
    {
        $tmp = explode('/', trim(APPPATH, '/'));
        $application_folder = end($tmp);
        unset($tmp);

        $subfolder = (empty($params['subfolder'])) ? '' : trim($params['subfolder'], '/') . '/';

        if (!$empty_migration && !empty($params['columns']) && !empty($params['types']))
        {
            $columns = '';
            foreach ($params['columns'] as $index => $column)
            {
                $columns .= $this->_generate_migration_column($column, $params['types'][$index]);
            }

            $table_name = str_replace('/', '_', $subfolder) . plural(strtolower($params['name']));
            $class_name = 'Migration_Add_' . $table_name;
            $filename = get_migration_number() . '_add_' . $table_name . '.php';

            $args = array(
                'class_name' => $class_name,
                'table_name' => $table_name,
                'parent_class' => $this->input->post('parent_migration'),
                'filename' => $filename,
                'application_folder' => $application_folder,
                'extra' => $columns
            );

            $migration = $this->template_scanner->parse('migration', $args);
        }
        else
        {
            $class_name = 'Migration_' . plural(underscore($params['name']));
            $filename = get_migration_number() . '_' . plural(underscore($params['name'])) . '.php';
            $args = array(
                'class_name' => $class_name,
                'parent_class' => $this->input->post('parent_migration'),
                'table_name' => get_table_name_from_migration_name(underscore($params['name'])),
                'filename' => $filename,
                'application_folder' => $application_folder,
            );

            $migration = $this->template_scanner->parse('empty_migration', $args);
        }

        $location['filename'] = $filename;

        return $migration;
    }

    private function _generate_migration_column($column, $type)
    {
        $args = $this->_generate_migration_column_attributes($type);
        $args = array($column => $args);
        return $this->template_scanner->parse('migration_column', $args);
    }

    private static function _generate_migration_column_attributes($type)
    {
        $attributes = array();

        switch ($type)
        {
            case 'string':
            case 'varchar':
                $attributes['type'] = 'VARCHAR';
                $attributes['constraint'] = 255;
                $attributes['null'] = FALSE;
                break;
            case 'text':
                $attributes['type'] = 'TEXT';
                break;
            case 'int':
            case 'integer':
                $attributes['type'] = 'INT';
                $attributes['unsigned'] = TRUE;
                $attributes['null'] = FALSE;
                break;
            case 'decimal':
                $attributes['type'] = 'DECIMAL';
                $attributes['unsigned'] = TRUE;
                $attributes['null'] = FALSE;
                break;
            case 'date':
                $attributes['type'] = 'DATE';
                break;
            case 'datetime':
                $attributes['type'] = 'DATETIME';
                break;
            case 'char':
                $attributes['type'] = 'CHAR';
                break;
        }

        return $attributes;
    }

    public function check_extra($str)
    {
        if (!empty($str) && preg_match('/\s+/', $str) === 1)
        {
            $this->form_validation->set_message('check_extra', 'The %s field may only contain alpha-numeric characters.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

} // End of the Generate

/* End of file generate.php */
/* Location application/controllers/fire/generate.php */
