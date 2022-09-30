<?php
namespace Sheet;

use \PDO;
use \RandomLib;

class SoSheety
{
  private $db_connection;
  public $required_fields = ['name', 'race', 'class'];

  public function __construct() {
    try {
      $this->db_connection = new PDO(
        "mysql:host=$_ENV[WTS_DB_HOSTNAME];dbname=$_ENV[WTS_DB_NAME]",
        $_ENV['WTS_DB_USERNAME'],
        $_ENV['WTS_DB_PASSWORD']
      );
    } catch (Exception $e) {
      error_log($e->getMessage(), 0);
      die("Something went wrong.");
    }
  }

  private function execute($query, $parameters = []) {
    $statement = $this->db_connection->prepare($query);
    $statement->execute($parameters);
    return $statement;
  }

  private function fetch($query, $parameters = []) {
    return $this->execute($query, $parameters)->fetch(PDO::FETCH_ASSOC);
  }

  private function fetch_all($query, $parameters = []) {
    return $this->execute($query, $parameters)->fetchAll(PDO::FETCH_ASSOC);
  }

  public function validate($sheet) {
    $errors = [];

    $fields_in_sheet = count(array_intersect_key(array_flip($this->required_fields), $sheet));
    $fields_total = count($this->required_fields);

    if ($fields_in_sheet !== $fields_total) {
      $errors[] = ['Not all parameters are present. We need: ' . implode(', ', $this->required_fields)];
    }

    return $errors;
  }

  public function get_by_id($id) {
    return $this->fetch('
      select
        *
      from
        `sheet`
      where
        `id` = :id
    ', [
      'id' => $id
    ]);
  }

  public function get_by_share_token($share_token) {
    return $this->fetch('
      select
        *
      from
        `sheet`
      where
        `share_token` = :share_token
    ', [
      'share_token' => $share_token
    ]);
  }

  public function create_sheet($name, $race, $class) {
    $factory = new RandomLib\Factory;
    $generator = $factory->getMediumStrengthGenerator();

    $sheet = [
      'id'     => $generator->generateString(32, 'abcdef0123456789')
     ,'name'   => $name
     ,'race'   => $race
     ,'class'  => $class
     ,'share_token'  => $generator->generateString(40, 'abcdef0123456789')
    ];

    $this->execute('
      insert into `sheet` (
         `id`
        ,`name`
        ,`race`
        ,`class`
        ,`share_token`
      )
      values (
         :id
        ,:name
        ,:race
        ,:class
        ,:share_token
      )
    ', $sheet);

    $sheet = $this->get_by_id($sheet['id']);
    return $sheet;
  }

  public function update_sheet($id, $name, $race, $class) {
    $this->execute('
      update `sheet`
      set `name` = :name,
          `race` = :race,
          `class` = :class
      where
        `id` = :id
    ', [
      'id'     => $id
     ,'name'   => $name
     ,'race'   => $race
     ,'class'  => $class
    ]);

    $sheet = $this->get_by_id($id);
    clear_varnish_cache($id, $sheet['share_token']);

    return $sheet;
  }
}
