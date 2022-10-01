<?php
namespace Sheet;

use \PDO;
use \RandomLib;

class SoSheety
{
  private $db_connection;
  public $fields = [
     'name'
    ,'race'
    ,'class'
    ,'level'
    ,'int'
    ,'int_mod'
    ,'int_saving_throw'
    ,'wis'
    ,'wis_mod'
    ,'wis_saving_throw'
    ,'char'
    ,'char_mod'
    ,'char_saving_throw'
    ,'str'
    ,'str_mod'
    ,'str_saving_throw'
    ,'dex'
    ,'dex_mod'
    ,'dex_saving_throw'
    ,'con'
    ,'con_mod'
    ,'con_saving_throw'
    ,'hp_max'
    ,'hp_cur'
    ,'hp_tmp'
    ,'hit_die'
    ,'armor_class'
    ,'initiative'
    ,'speed'
  ];

  public function __construct() {
    try {
      // Create a connection purely in memory for tests
      if (getenv('WTS_DB_IN_MEMORY') && getenv('WTS_DB_IN_MEMORY') == 1) {
        $this->db_connection = new PDO('sqlite::memory:');

        $sql = file_get_contents(__DIR__.'/../../structure.sql');
        $this->db_connection->exec($sql);

      // Create a regular MySQL connection
      } else {
        $this->db_connection = new PDO(
          'mysql:host=' . getenv('WTS_DB_HOSTNAME') . ';dbname=' . getenv('WTS_DB_NAME'),
          getenv('WTS_DB_USERNAME'),
          getenv('WTS_DB_PASSWORD')
        );
      }
    } catch (Exception $e) {
      $logger->error($e->getMessage());
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

    $fields_in_sheet = count(array_intersect_key(array_flip($this->fields), $sheet));
    $fields_total = count($this->fields);

    if ($fields_in_sheet !== $fields_total) {
      $errors[] = 'Not all parameters are present. We need: ' . implode(', ', $this->fields);
    } else if (count($sheet) !== $fields_total) {
      $errors[] = 'At least one unknown field is present.';
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

  public function create_sheet($sheet) {
    $factory = new RandomLib\Factory;
    $generator = $factory->getMediumStrengthGenerator();

    $sheet = array_merge($sheet, [
      'id'     => $generator->generateString(32, 'abcdef0123456789')
     ,'share_token'  => $generator->generateString(40, 'abcdef0123456789')
    ]);

    $this->execute('
      insert into `sheet` (
         `id`
        ,`name`
        ,`race`
        ,`class`
        ,`level`
        ,`int`
        ,`int_mod`
        ,`int_saving_throw`
        ,`wis`
        ,`wis_mod`
        ,`wis_saving_throw`
        ,`char`
        ,`char_mod`
        ,`char_saving_throw`
        ,`str`
        ,`str_mod`
        ,`str_saving_throw`
        ,`dex`
        ,`dex_mod`
        ,`dex_saving_throw`
        ,`con`
        ,`con_mod`
        ,`con_saving_throw`
        ,`hp_max`
        ,`hp_cur`
        ,`hp_tmp`
        ,`hit_die`
        ,`armor_class`
        ,`initiative`
        ,`speed`
        ,`share_token`
      )
      values (
         :id
        ,:name
        ,:race
        ,:class
        ,:level
        ,:int
        ,:int_mod
        ,:int_saving_throw
        ,:wis
        ,:wis_mod
        ,:wis_saving_throw
        ,:char
        ,:char_mod
        ,:char_saving_throw
        ,:str
        ,:str_mod
        ,:str_saving_throw
        ,:dex
        ,:dex_mod
        ,:dex_saving_throw
        ,:con
        ,:con_mod
        ,:con_saving_throw
        ,:hp_max
        ,:hp_cur
        ,:hp_tmp
        ,:hit_die
        ,:armor_class
        ,:initiative
        ,:speed
        ,:share_token
      )
    ', $sheet);

    $sheet = $this->get_by_id($sheet['id']);
    return $sheet;
  }

  public function update_sheet($id, $sheet) {
    $sheet['id'] = $id;

    $this->execute('
      update `sheet`
      set `name` = :name,
          `race` = :race,
          `class` = :class,
          `level` = :level,
          `int` = :int,
          `int_mod` = :int_mod,
          `int_saving_throw` = :int_saving_throw,
          `wis` = :wis,
          `wis_mod` = :wis_mod,
          `wis_saving_throw` = :wis_saving_throw,
          `char` = :char,
          `char_mod` = :char_mod,
          `char_saving_throw` = :char_saving_throw,
          `str` = :str,
          `str_mod` = :str_mod,
          `str_saving_throw` = :str_saving_throw,
          `dex` = :dex,
          `dex_mod` = :dex_mod,
          `dex_saving_throw` = :dex_saving_throw,
          `con` = :con,
          `con_mod` = :con_mod,
          `con_saving_throw` = :con_saving_throw,
          `hp_max` = :hp_max,
          `hp_cur` = :hp_cur,
          `hp_tmp` = :hp_tmp,
          `hit_die` = :hit_die,
          `armor_class` = :armor_class,
          `initiative` = :initiative,
          `speed` = :speed
      where
        `id` = :id
    ', $sheet);

    $sheet = $this->get_by_id($id);
    clear_varnish_cache($id, $sheet['share_token']);

    return $sheet;
  }
}
