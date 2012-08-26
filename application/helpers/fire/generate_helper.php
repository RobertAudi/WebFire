<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function does_controller_exist(array $params)
{
    $result = FALSE;
    if (!empty($params['subfolder']))
    {
        $result = is_file(APPPATH . 'controllers/' . trim($params['subfolder'], '/') . '/' . $params['name'] . '.php');
    }
    else
    {
        $result = is_file(APPPATH . 'controllers/' . $params['name'] . '.php');
    }

    return $result;
}

function does_model_exist(array $params)
{
    $result = FALSE;
    if (!empty($params['subfolder']))
    {
        $result = is_file(APPPATH . 'models/' . trim($params['subfolder'], '/') . '/' . $params['name'] . '.php');
    }
    else
    {
        $result = is_file(APPPATH . 'models/' . $params['name'] . '.php');
    }

    return $result;
}

function does_migration_exist(array $params)
{
    return is_file(APPPATH . 'migrations/' . get_latest_migration_number_formatted() . '_' . underscore($params['name']) . '.php');
}

function get_migration_number_from_config_file($application_folder)
{
    $config_file = $application_folder . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'migration.php';
    if (is_file($config_file))
    {
        $config_file_contents = file_get_contents($config_file);
        preg_match('/\$config\[\'migration_version\'\] = (?P<migration_number>\d+);/', $config_file_contents, $matches);
        return intval($matches['migration_number']);
    }
    else
    {
        return FALSE;
    }
}

function get_latest_migration_number()
{
    $migrations = glob(APPPATH . 'migrations/*.php');
    $tmp = end($migrations);
    $tmp = explode('/', $tmp);
    $migration = end($tmp);
    $migration_number = intval($migration);

    return $migration_number;
}

function get_latest_migration_number_formatted()
{
    $migrations = glob(APPPATH . 'migrations/*.php');
    $tmp = end($migrations);
    $tmp = explode('/', $tmp);
    $migration = end($tmp);
    $tmp = explode('_', $migration);
    $migration_number = $tmp[0];

    if (empty($migration_number))
    {
        $migration_number = '001';
    }

    return $migration_number;
}

function get_migration_number()
{
    $migration_number = get_latest_migration_number();
    $migration_number++;

    if ($migration_number < 10)
    {
        $migration_number = '00' . $migration_number;
    }
    else if ($migration_number < 100)
    {
        $migration_number = '0' . $migration_number;
    }
    else
    {
        $migration_number = strval($migration_number);
    }

    return $migration_number;
}

function decrement_migration_number($migration_number)
{
    $migration_number = intval($migration_number);
    $migration_number--;

    if ($migration_number < 10)
    {
        $migration_number = '00' . $migration_number;
    }
    else if ($migration_number < 100)
    {
        $migration_number = '0' . $migration_number;
    }
    else
    {
        $migration_number = strval($migration_number);
    }

    return $migration_number;
}

function add_migration_number_to_config_file($migration_number)
{
    $ci = get_instance();
    $ci->load->helper('file');

    $config_file = APPPATH . 'config/migration.php';
    if (is_file($config_file))
    {
        $config_file_contents = file_get_contents($config_file);
        $config_file_contents = preg_replace('/\$config\[\'migration_version\'\] = \d+;/', '$config[\'migration_version\'] = ' . intval($migration_number) . ';', $config_file_contents);

        if (write_file($config_file, $config_file_contents))
        {
            return TRUE;
        }
        else
        {
            // TODO: Find a clean way to return an error message saying that the migration succeeded but that the migration count could not be incremented in the config file
            return FALSE;
        }

    }
    else
    {
        return FALSE;
    }
}

function get_table_name_from_migration_name($migration_name)
{
    $patterns = array(
        '/create_(?P<table_name>\w+)$/',
        '/add_\w+_to_(?P<table_name>\w+)$/',
        '/add_(?P<table_name>\w+)$/'
    );

    $table_name = "";
    foreach ($patterns as $pattern)
    {
        if (preg_match($pattern, $migration_name, $matches) === 1)
        {
            $table_name = $matches['table_name'];
            break;
        }
    }

    return $table_name;

}
