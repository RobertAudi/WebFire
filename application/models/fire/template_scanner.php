<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Template_scanner
 */
class Template_scanner
{
    private $template_name;
    private $class_name;
    private $parent_class;
    private $view_folder;
    private $extra;
    private $filename;
    private $table_name;
    private $application_folder;
    private $relative_location;


    public function parse($template_name, array $params)
    {
        $this->template_name = $template_name;
        $template = $this->get_template($template_name);
        if ($template)
        {
            $this->set_attributes($params);

            $patterns = array(
              "/{{class_name}}/",
              "/{{parent_class}}/",
              "/{{view_folder}}/",
              "/{{extra}}/",
              "/{{filename}}/",
              "/{{table_name}}/",
              "/{{application_folder}}/",
              "/{{relative_location}}/"
            );

            $replacements = array(
              $this->class_name,
              $this->parent_class,
              $this->view_folder,
              $this->extra,
              $this->filename,
              $this->table_name,
              $this->application_folder,
              $this->relative_location,
            );
            return preg_replace($patterns, $replacements, $template);
        }
    }

    private function get_template($template_name)
    {
        $path = APPPATH . 'views/fire/templates/' . $template_name . '.tpl';
        if (file_exists($path))
        {
            return file_get_contents($path);
        }
        else
        {
            return false;
        }
    }


    private function set_attributes(array $args)
    {
        if ($this->template_name == 'migration_column')
        {
            $this->set_migration_column_attributes($args);
        }
        else
        {
            $valid_attributes = array(
                "class_name"         => 'My' . ucfirst($this->template_name),
                "parent_class"       => 'CI_' . ucfirst($this->template_name),
                "extra"              => "",
                "filename"           => 'my_' . $this->template_name . '.php',
                "table_name"         => "my_table",
                "application_folder" => "application",
                'view_folder'        => strtolower($this->template_name),
                'relative_location'  => 'application' . DIRECTORY_SEPARATOR . 'my_' . $this->template_name . '.php',
            );

            foreach ($valid_attributes as $valid_attribute => $default_value)
            {
                if (array_key_exists($valid_attribute, $args))
                {
                    $this->$valid_attribute = $args[$valid_attribute];
                }
                else
                {
                    $this->$valid_attribute = $default_value;
                }
            }
        }

        return;
    }

    private function set_migration_column_attributes(array $args)
    {
        $column_name = key($args);
        $column_attributes = reset($args);
        $extra = "\t\t\t'" . $column_name . '\' => array(' . PHP_EOL;

        foreach ($column_attributes as $attr => $value)
        {
            $extra .= "\t\t\t\t'" . $attr . "' => ";

            if (is_int($value) || is_real($value))
            {
                $extra .= $value;
            }
            else if (is_bool($value))
            {
                $extra .= ($value) ? 'TRUE' : 'FALSE';
            }
            else
            {
                $extra .= "'" . $value . "'";
            }

            $extra .= ',' . PHP_EOL;
        }

        $extra .= "\t\t\t)," . PHP_EOL;

        $this->extra = $extra;

        return;
    }
} // End of the Template_scanner

/* End of file template_scanner.php */
/* Location application/models/fire/template_scanner.php */
