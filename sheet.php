<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class SoSheety {
  private $db_connection;

  function __construct() {
    try {
      $this->db_connection = new PDO("mysql:host=$_ENV[DB_HOSTNAME];dbname=$_ENV[DB_NAME]", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
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
    return $this->execute($query, $parameters)->fetch();
  }

  private function fetch_all($query, $parameters = []) {
    return $this->execute($query, $parameters)->fetchAll();
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

  public function create_sheet($name, $race, $class) {
    $factory = new RandomLib\Factory;
    $generator = $factory->getMediumStrengthGenerator();
    $id = $generator->generateString(32, 'abcdef0123456789');

    $this->execute('
      insert into `sheet` (
         `id`
        ,`name`
        ,`race`
        ,`class`
      )
      values (
         :id
        ,:name
        ,:race
        ,:class
      )
    ', [
       'id'     => $id
      ,'name'   => $name
      ,'race'   => $race
      ,'class'  => $class
    ]);

    return $id;
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
       'name'   => $name
      ,'race'   => $race
      ,'class'  => $class
      ,'id'     => $id
    ]);

    return $id;
  }
}
