<?php
namespace Sheet;

use \PDO;
use \RandomLib;
use Rakit\Validation\Validator;

class SoSheety
{
  private $db_connection;
  public $validation_rules = [
     'name'                   => 'required|max:50'
    ,'race'                   => 'required|max:50'
    ,'class'                  => 'required|max:50'
    ,'level'                  => 'nullable|numeric|min:1|max:100'
    ,'int'                    => 'nullable|numeric|min:0|max:100'
    ,'int_mod'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'int_saving_throw'       => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'wis'                    => 'nullable|numeric|min:0|max:100'
    ,'wis_mod'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'wis_saving_throw'       => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'char'                   => 'nullable|numeric|min:0|max:100'
    ,'char_mod'               => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'char_saving_throw'      => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'str'                    => 'nullable|numeric|min:0|max:100'
    ,'str_mod'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'str_saving_throw'       => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'dex'                    => 'nullable|numeric|min:0|max:100'
    ,'dex_mod'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'dex_saving_throw'       => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'con'                    => 'nullable|numeric|min:0|max:100'
    ,'con_mod'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'con_saving_throw'       => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'hp_max'                 => 'nullable|numeric|min:0|max:1000'
    ,'hp_cur'                 => 'nullable|numeric|min:0|max:1000'
    ,'hp_tmp'                 => 'nullable|numeric|min:0|max:1000'
    ,'hit_die'                => 'nullable|regex:/^[0-9]{1,2}d[0-9]{1,2}$/'
    ,'armor_class'            => 'nullable|numeric|min:0|max:1000'
    ,'initiative'             => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'speed'                  => 'nullable|numeric|min:0|max:1000'

    ,'acrobatics'             => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'animal_handling'        => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'arcana'                 => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'athletics'              => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'deception'              => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'history'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'insight'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'intimidation'           => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'investigation'          => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'medicine'               => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'nature'                 => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'perception'             => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'performance'            => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'persuasion'             => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'religion'               => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'sleight_of_hand'        => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'stealth'                => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
    ,'survival'               => 'nullable|regex:/^[\+\-]{1}[0-9]{1,2}$/'
  ];

  public function __construct($db_connection) {
    $this->db_connection = $db_connection;
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

  public function validate($sheet) {
    $errors = [];

    $validator = new Validator;
    $validation = $validator->validate($sheet, $this->validation_rules);
    
    $unknown_fields = array_diff_key($sheet, $this->validation_rules);
    $fields_missing = array_diff_key($this->validation_rules, $sheet);

    if (count($unknown_fields) !== 0) {
      $errors[] = 'Unknown field(s) in request: ' . implode(', ', array_keys($unknown_fields));
    }

    if (count($fields_missing) !== 0) {
      $errors[] = 'Field(s) missing in request: ' . implode(', ', array_keys($fields_missing));
    }

    if ($validation->fails()) {
      $validation_errors = $validation->errors();
      $errors = array_merge($errors, $validation_errors->all());
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
        ,`acrobatics`
        ,`animal_handling`
        ,`arcana`
        ,`athletics`
        ,`deception`
        ,`history`
        ,`insight`
        ,`intimidation`
        ,`investigation`
        ,`medicine`
        ,`nature`
        ,`perception`
        ,`performance`
        ,`persuasion`
        ,`religion`
        ,`sleight_of_hand`
        ,`stealth`
        ,`survival`
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
        ,:acrobatics
        ,:animal_handling
        ,:arcana
        ,:athletics
        ,:deception
        ,:history
        ,:insight
        ,:intimidation
        ,:investigation
        ,:medicine
        ,:nature
        ,:perception
        ,:performance
        ,:persuasion
        ,:religion
        ,:sleight_of_hand
        ,:stealth
        ,:survival
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
          `speed` = :speed,
          `acrobatics` = :acrobatics,
          `animal_handling` = :animal_handling,
          `arcana` = :arcana,
          `athletics` = :athletics,
          `deception` = :deception,
          `history` = :history,
          `insight` = :insight,
          `intimidation` = :intimidation,
          `investigation` = :investigation,
          `medicine` = :medicine,
          `nature` = :nature,
          `perception` = :perception,
          `performance` = :performance,
          `persuasion` = :persuasion,
          `religion` = :religion,
          `sleight_of_hand` = :sleight_of_hand,
          `stealth` = :stealth,
          `survival` = :survival
      where
        `id` = :id
    ', $sheet);

    $sheet = $this->get_by_id($id);
    clear_varnish_cache($id, $sheet['share_token']);

    return $sheet;
  }

  public function delete_sheet($id) {
    $sheet = $this->get_by_id($id);

    $this->execute('
      delete from `sheet`
      where `id` = :id
    ', ["id" => $id]);

    clear_varnish_cache($id, $sheet['share_token']);

    return $sheet;
  }
}
