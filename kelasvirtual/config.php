<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->auth_dbtype      = 'mysqli';
$CFG->auth_dblibrary   = 'native';
$CFG->auth_dbhost      = 'localhost';
$CFG->auth_dbname      = 'tvsekolah_db';
$CFG->auth_dbuser      = 'root';
$CFG->auth_dbpass      = '';
$CFG->auth_dbtable     = 'tb_user';
$CFG->auth_dbfielduser = 'first_name';
$CFG->auth_dbfieldpass = 'code';

$CFG->wwwroot   = 'http://localhost/kampustv/kelasvirtual';
$CFG->dataroot  = 'D:\\laragon\\kelasvirtualdata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
