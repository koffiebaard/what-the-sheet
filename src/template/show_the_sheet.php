<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>What the Sheet</title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  <body>
    <div id="sheet-container">
    <img
      src="/assets/what-the-sheet.png" 
      id="sheet" 
      data-id="<?=$sheet['id'] ?? ''; ?>" 
      data-share_token="<?=$sheet['share_token'] ?? ''; ?>"
    >
    <button class="save">Save</button>
    <button class="share" <?php if (!isset($sheet)) {
      echo "style='display: none'";
                          } ?>>Share</button>
    <input type="text" name="class" value="<?=$sheet['class'] ?? ''; ?>" id="class" placeholder="class" />
    <input type="text" name="name" value="<?=$sheet['name'] ?? ''; ?>" id="name" placeholder="Name" />
    <input type="text" name="race" value="<?=$sheet['race'] ?? ''; ?>" id="race" placeholder="Race" />
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
    <button>Save</button>
  </dialog>
  <dialog class="share">
    <h1>Share sheet</h1>
    <textarea><?=$web_address; ?>/share/<?=$sheet['share_token'] ?? ''; ?></textarea>
    <button>Close</button>
  </dialog>
  <script src="assets/script.js"></script>
  </body>
</html>
