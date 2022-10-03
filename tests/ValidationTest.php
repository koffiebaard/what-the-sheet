<?php
use PHPUnit\Framework\TestCase as BaseTestCase;

define('VALID_MOCK', [
  "name" => "Merry",
  "race" => "Hobbit",
  "class" => "Rogue",
  "level" => "3",
  "int" => "16",
  "int_mod" => "+3",
  "int_saving_throw" => "+4",
  "wis" => "18",
  "wis_mod" => "+4",
  "wis_saving_throw" => "+5",
  "char" => "12",
  "char_mod" => "+2",
  "char_saving_throw" => "+5",
  "str" => "13",
  "str_mod" => "+1",
  "str_saving_throw" => "-2",
  "dex" => "17",
  "dex_mod" => "+3",
  "dex_saving_throw" => "+2",
  "con" => "10",
  "con_mod" => "-1",
  "con_saving_throw" => "-1",
  "hp_max" => "49",
  "hp_cur" => "25",
  "hp_tmp" => "0",
  "hit_die" => "1d8",
  "armor_class" => "16",
  "initiative" => "+3",
  "speed" => "30"
]);

class ValidationTest extends BaseTestCase {
  private $so_sheety;

  protected function setUp(): void {
    $this->so_sheety = new Sheet\SoSheety();
  }

  public function test_valid_mock() {
    $errors = $this->so_sheety->validate(VALID_MOCK);
    $this->assertEquals([], $errors);
  }

  public function test_only_class_race_name() {
    // Set mock to all values on null
    $empty_mock = array_map(function () {
      return null;
    }, VALID_MOCK);

    $errors = $this->so_sheety->validate([...$empty_mock, ...[
      'class' => VALID_MOCK['class'],
      'race' => VALID_MOCK['race'],
      'name' => VALID_MOCK['name']
    ]]);

    $this->assertEquals([], $errors);

    $errors = $this->so_sheety->validate($empty_mock);
    $this->assertEquals(3, count($errors));
  }

  public function test_fields_with_empty_strings() {
    // Set mock to all values to an empty string
    $empty_mock = array_map(function () {
      return "";
    }, VALID_MOCK);

    $errors = $this->so_sheety->validate([...$empty_mock, ...[
      'class' => VALID_MOCK['class'],
      'race' => VALID_MOCK['race'],
      'name' => VALID_MOCK['name']
    ]]);

    $this->assertEquals([], $errors);

    $errors = $this->so_sheety->validate($empty_mock);
    $this->assertEquals(3, count($errors));
  }

  public function test_mock_hp_not_int() {
    $errors = $this->so_sheety->validate([...VALID_MOCK, ...[
      "hp_max" => "1d8",
      "hp_cur" => "44d"
    ]]);
    $this->assertEquals(2, count($errors));
  }

  public function test_mock_hp_optional() {
    $errors = $this->so_sheety->validate([...VALID_MOCK, ...[
      "hp_max" => "",
      "hp_cur" => "",
      "hp_tmp" => ""
    ]]);
    $this->assertEquals(0, count($errors));
  }

  public function test_level() {
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...["level" => ""]])));
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...["level" => 10]])));

    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["level" => 0]])));
    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["level" => -1]])));
    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["level" => 1000]])));
  }

  public function test_mock_modifier_plus_prefix() {
    $errors = $this->so_sheety->validate([...VALID_MOCK, ...[
      "int_mod"           => "+3",
      "wis_mod"           => "+4",
      "char_mod"          => "+2",
      "str_mod"           => "+1",
      "dex_mod"           => "+3",
      "con_mod"           => "+1",

      "int_saving_throw"  => "+4",
      "wis_saving_throw"  => "+5",
      "char_saving_throw" => "+5",
      "str_saving_throw"  => "+2",
      "dex_saving_throw"  => "+2",
      "con_saving_throw"  => "+1",

      "initiative"        => "+1",
    ]]);
    $this->assertEquals(0, count($errors));
  }

  public function test_mock_modifier_minus_prefix() {
    $errors = $this->so_sheety->validate([...VALID_MOCK, ...[
      "int_mod"           => "-3",
      "wis_mod"           => "-4",
      "char_mod"          => "-2",
      "str_mod"           => "-1",
      "dex_mod"           => "-3",
      "con_mod"           => "-1",

      "int_saving_throw"  => "-4",
      "wis_saving_throw"  => "-5",
      "char_saving_throw" => "-5",
      "str_saving_throw"  => "-2",
      "dex_saving_throw"  => "-2",
      "con_saving_throw"  => "-1",

      "initiative"        => "-1",
    ]]);
    $this->assertEquals(0, count($errors));
  }

  public function test_mock_modifier_double_digits() {
    $errors = $this->so_sheety->validate([...VALID_MOCK, ...[
      "int_mod"           => "+30",
      "wis_mod"           => "+40",
      "char_mod"          => "+20",
      "str_mod"           => "+10",
      "dex_mod"           => "+30",
      "con_mod"           => "+10",

      "int_saving_throw"  => "-40",
      "wis_saving_throw"  => "-50",
      "char_saving_throw" => "-50",
      "str_saving_throw"  => "-20",
      "dex_saving_throw"  => "-20",
      "con_saving_throw"  => "-10",

      "initiative"        => "-10",
    ]]);
    $this->assertEquals(0, count($errors));
  }

  public function test_mock_modifier_triple_digits() {
    $errors = $this->so_sheety->validate([...VALID_MOCK, ...[
      "int_mod"           => "+300",
      "wis_mod"           => "+400",
      "char_mod"          => "+200",
      "str_mod"           => "+100",
      "dex_mod"           => "+300",
      "con_mod"           => "+100",

      "int_saving_throw"  => "-400",
      "wis_saving_throw"  => "-500",
      "char_saving_throw" => "-500",
      "str_saving_throw"  => "-200",
      "dex_saving_throw"  => "-200",
      "con_saving_throw"  => "-100",

      "initiative"        => "-100",
    ]]);
    $this->assertEquals(13, count($errors));
  }

  public function test_mock_hit_die() {
    // Valid die
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "1d1"]])));
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "1d8"]])));
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "1d12"]])));
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "10d12"]])));

    // Invalid die
    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "1d100"]])));
    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "100d1"]])));
    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "1"]])));
    $this->assertEquals(1, count($this->so_sheety->validate([...VALID_MOCK, ...["hit_die" => "d8"]])));
  }

  public function test_ability_scores() {
    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...[
      "int"           => 0,
      "wis"           => 0,
      "char"          => 0,
      "str"           => 0,
      "dex"           => 0,
      "con"           => 0,
    ]])));

    $this->assertEquals(0, count($this->so_sheety->validate([...VALID_MOCK, ...[
      "int"           => 10,
      "wis"           => 10,
      "char"          => 10,
      "str"           => 10,
      "dex"           => 10,
      "con"           => 10,
    ]])));

    $this->assertEquals(6, count($this->so_sheety->validate([...VALID_MOCK, ...[
      "int"           => -1,
      "wis"           => -1,
      "char"          => -1,
      "str"           => -1,
      "dex"           => -1,
      "con"           => -1,
    ]])));
  }
}
