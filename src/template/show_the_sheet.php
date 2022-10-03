<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>What the Sheet</title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  <body id="save">
    <div id="sheet-container">
      <img
        src="/assets/what-the-sheet.png" 
        id="sheet" 
        data-id="<?=$sheet['id'] ?? ''; ?>" 
        data-share_token="<?=$sheet['share_token'] ?? ''; ?>"
      >
      <button class="open_save">Save</button>
      <button class="open_share" <?php if (!isset($sheet)) {
        echo "style='display: none'";
                                 } ?>>Share</button>
      <input type="text" name="class" value="<?=$sheet['class'] ?? ''; ?>" id="class" placeholder="class" />
      <input type="text" name="name" value="<?=$sheet['name'] ?? ''; ?>" id="name" placeholder="Name" />
      <input type="text" name="race" value="<?=$sheet['race'] ?? ''; ?>" id="race" placeholder="Race" />
      <input type="text" name="level" value="<?=$sheet['level'] ?? ''; ?>" id="level" placeholder="" />
      <input type="text" name="int" value="<?=$sheet['int'] ?? ''; ?>" id="int" placeholder="" />
      <input type="text" name="int_mod" value="<?=$sheet['int_mod'] ?? ''; ?>" id="int_mod" placeholder="" />
      <input type="text" name="int_saving_throw" value="<?=$sheet['int_saving_throw'] ?? ''; ?>" id="int_saving_throw" placeholder="" />
      <input type="text" name="wis" value="<?=$sheet['wis'] ?? ''; ?>" id="wis" placeholder="" />
      <input type="text" name="wis_mod" value="<?=$sheet['wis_mod'] ?? ''; ?>" id="wis_mod" placeholder="" />
      <input type="text" name="wis_saving_throw" value="<?=$sheet['wis_saving_throw'] ?? ''; ?>" id="wis_saving_throw" placeholder="" />
      <input type="text" name="char" value="<?=$sheet['char'] ?? ''; ?>" id="char" placeholder="" />
      <input type="text" name="char_mod" value="<?=$sheet['char_mod'] ?? ''; ?>" id="char_mod" placeholder="" />
      <input type="text" name="char_saving_throw" value="<?=$sheet['char_saving_throw'] ?? ''; ?>" id="char_saving_throw" placeholder="" />
      <input type="text" name="str" value="<?=$sheet['str'] ?? ''; ?>" id="str" placeholder="" />
      <input type="text" name="str_mod" value="<?=$sheet['str_mod'] ?? ''; ?>" id="str_mod" placeholder="" />
      <input type="text" name="str_saving_throw" value="<?=$sheet['str_saving_throw'] ?? ''; ?>" id="str_saving_throw" placeholder="" />
      <input type="text" name="dex" value="<?=$sheet['dex'] ?? ''; ?>" id="dex" placeholder="" />
      <input type="text" name="dex_mod" value="<?=$sheet['dex_mod'] ?? ''; ?>" id="dex_mod" placeholder="" />
      <input type="text" name="dex_saving_throw" value="<?=$sheet['dex_saving_throw'] ?? ''; ?>" id="dex_saving_throw" placeholder="" />
      <input type="text" name="con" value="<?=$sheet['con'] ?? ''; ?>" id="con" placeholder="" />
      <input type="text" name="con_mod" value="<?=$sheet['con_mod'] ?? ''; ?>" id="con_mod" placeholder="" />
      <input type="text" name="con_saving_throw" value="<?=$sheet['con_saving_throw'] ?? ''; ?>" id="con_saving_throw" placeholder="" />
      <input type="text" name="hp_max" value="<?=$sheet['hp_max'] ?? ''; ?>" id="hp_max" placeholder="" />
      <input type="text" name="hp_cur" value="<?=$sheet['hp_cur'] ?? ''; ?>" id="hp_cur" placeholder="" />
      <input type="text" name="hp_tmp" value="<?=$sheet['hp_tmp'] ?? ''; ?>" id="hp_tmp" placeholder="" />
      <input type="text" name="hit_die" value="<?=$sheet['hit_die'] ?? ''; ?>" id="hit_die" placeholder="" />
      <input type="text" name="armor_class" value="<?=$sheet['armor_class'] ?? ''; ?>" id="armor_class" placeholder="" />
      <input type="text" name="initiative" value="<?=$sheet['initiative'] ?? ''; ?>" id="initiative" placeholder="" />
      <input type="text" name="speed" value="<?=$sheet['speed'] ?? ''; ?>" id="speed" placeholder="" />
    </div>
    <dialog class="save">
      <h1>Save sheet</h1>
      <div class="notice success">
        Your sheet has been saved!
      </div>
      <div class="notice fail">
        Something went wrong. Sorry.
      </div>
      <p>Are you sure? It looks like sheet.</p>
      <button class="save">Save</button>
      <button class="close">Close</button>
    </dialog>
    <dialog class="share">
      <h1>Share sheet</h1>
      <textarea><?=$web_address; ?>/share/<?=$sheet['share_token'] ?? ''; ?></textarea>
      <button class="close">Close</button>
    </dialog>
    <script src="assets/script.js"></script>
  </body>
</html>
