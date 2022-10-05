<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>What the Sheet</title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  <body id="share">
  <div id="sheet-container">
    <img src="/assets/what-the-sheet.png" id="sheet">
    <input type="text" name="class" value="<?php echo $sheet['class'] ?? ''; ?>" id="class" disabled />
    <input type="text" name="name" value="<?php echo $sheet['name'] ?? ''; ?>" id="name" disabled />
    <input type="text" name="race" value="<?php echo $sheet['race'] ?? ''; ?>" id="race" disabled />
    <input type="text" name="level" value="<?=$sheet['level'] ?? ''; ?>" id="level" disabled />
    <input type="text" name="int" value="<?=$sheet['int'] ?? ''; ?>" id="int" disabled />
    <input type="text" name="int_mod" value="<?=$sheet['int_mod'] ?? ''; ?>" id="int_mod" disabled />
    <input type="text" name="int_saving_throw" value="<?=$sheet['int_saving_throw'] ?? ''; ?>" id="int_saving_throw" disabled />
    <input type="text" name="wis" value="<?=$sheet['wis'] ?? ''; ?>" id="wis" disabled />
    <input type="text" name="wis_mod" value="<?=$sheet['wis_mod'] ?? ''; ?>" id="wis_mod" disabled />
    <input type="text" name="wis_saving_throw" value="<?=$sheet['wis_saving_throw'] ?? ''; ?>" id="wis_saving_throw" disabled />
    <input type="text" name="char" value="<?=$sheet['char'] ?? ''; ?>" id="char" disabled />
    <input type="text" name="char_mod" value="<?=$sheet['char_mod'] ?? ''; ?>" id="char_mod" disabled />
    <input type="text" name="char_saving_throw" value="<?=$sheet['char_saving_throw'] ?? ''; ?>" id="char_saving_throw" disabled />
    <input type="text" name="str" value="<?=$sheet['str'] ?? ''; ?>" id="str" disabled />
    <input type="text" name="str_mod" value="<?=$sheet['str_mod'] ?? ''; ?>" id="str_mod" disabled />
    <input type="text" name="str_saving_throw" value="<?=$sheet['str_saving_throw'] ?? ''; ?>" id="str_saving_throw" disabled />
    <input type="text" name="dex" value="<?=$sheet['dex'] ?? ''; ?>" id="dex" disabled />
    <input type="text" name="dex_mod" value="<?=$sheet['dex_mod'] ?? ''; ?>" id="dex_mod" disabled />
    <input type="text" name="dex_saving_throw" value="<?=$sheet['dex_saving_throw'] ?? ''; ?>" id="dex_saving_throw" disabled />
    <input type="text" name="con" value="<?=$sheet['con'] ?? ''; ?>" id="con" disabled />
    <input type="text" name="con_mod" value="<?=$sheet['con_mod'] ?? ''; ?>" id="con_mod" disabled />
    <input type="text" name="con_saving_throw" value="<?=$sheet['con_saving_throw'] ?? ''; ?>" id="con_saving_throw" disabled />
    <input type="text" name="hp_max" value="<?=$sheet['hp_max'] ?? ''; ?>" id="hp_max" disabled />
    <input type="text" name="hp_cur" value="<?=$sheet['hp_cur'] ?? ''; ?>" id="hp_cur" disabled />
    <input type="text" name="hp_tmp" value="<?=$sheet['hp_tmp'] ?? ''; ?>" id="hp_tmp" disabled />
    <input type="text" name="hit_die" value="<?=$sheet['hit_die'] ?? ''; ?>" id="hit_die" disabled />
    <input type="text" name="armor_class" value="<?=$sheet['armor_class'] ?? ''; ?>" id="armor_class" disabled />
    <input type="text" name="initiative" value="<?=$sheet['initiative'] ?? ''; ?>" id="initiative" disabled />
    <input type="text" name="speed" value="<?=$sheet['speed'] ?? ''; ?>" id="speed" disabled />
    <input type="text" name="acrobatics" value="<?=$sheet['acrobatics'] ?? ''; ?> id="acrobatics" disabled />
    <input type="text" name="sleight_of_hand" value="<?=$sheet['animal_handling'] ?? ''; ?> id="sleight_of_hand" disabled />
    <input type="text" name="stealth" value="<?=$sheet['arcana'] ?? ''; ?> id="stealth" disabled />
    <input type="text" name="arcana" value="<?=$sheet['athletics'] ?? ''; ?> id="arcana" disabled />
    <input type="text" name="history" value="<?=$sheet['deception'] ?? ''; ?> id="history" disabled />
    <input type="text" name="investigation" value="<?=$sheet['history'] ?? ''; ?> id="investigation" disabled />
    <input type="text" name="nature" value="<?=$sheet['insight'] ?? ''; ?> id="nature" disabled />
    <input type="text" name="religion" value="<?=$sheet['intimidation'] ?? ''; ?> id="religion" disabled />
    <input type="text" name="deception" value="<?=$sheet['investigation'] ?? ''; ?> id="deception" disabled />
    <input type="text" name="intimidation" value="<?=$sheet['medicine'] ?? ''; ?> id="intimidation" disabled />
    <input type="text" name="performance" value="<?=$sheet['nature'] ?? ''; ?> id="performance" disabled />
    <input type="text" name="persuasion" value="<?=$sheet['perception'] ?? ''; ?> id="persuasion" disabled />
    <input type="text" name="animal_handling" value="<?=$sheet['performance'] ?? ''; ?> id="animal_handling" disabled />
    <input type="text" name="insight" value="<?=$sheet['persuasion'] ?? ''; ?> id="insight" disabled />
    <input type="text" name="medicine" value="<?=$sheet['religion'] ?? ''; ?> id="medicine" disabled />
    <input type="text" name="perception" value="<?=$sheet['sleight_of_hand'] ?? ''; ?> id="perception" disabled />
    <input type="text" name="survival" value="<?=$sheet['stealth'] ?? ''; ?> id="survival" disabled />
    <input type="text" name="athletics" value="<?=$sheet['survival'] ?? ''; ?> id="athletics" disabled />
  </div>
  </body>
</html>
