<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>What the Sheet</title>
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>
	<div id="sheet-container">
    <img src="assets/what-the-sheet.png" id="sheet">
    <input type="text" name="class" value="<?=$sheet['class'] ?? ''; ?>" id="class" placeholder="class" />
    <input type="text" name="name" value="<?=$sheet['name'] ?? ''; ?>" id="name" placeholder="Name" />
    <input type="text" name="race" value="<?=$sheet['race'] ?? ''; ?>" id="race" placeholder="Race" />
  </div>
  </body>
</html>
