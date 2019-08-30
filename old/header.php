<header id="top">
    <h1 class="centered">Home Astrid</h1>
    <nav id="mainnav">
      <ul>
        <li><a href="index.php" <?php if($active == 'home') {echo 'class="thispage"';} ?>>Home</a></li>
        <li><a href="Praesidium.php" <?php if($active == 'praesidium') {echo 'class="thispage"';} ?>>Praesidium</a></li>
        <li><a href="Activiteiten.php" <?php if($active == 'activiteiten') {echo 'class="thispage"';} ?>>Activiteiten</a></li>
        <li><a href="Fotos.php" <?php if($active == 'foto') {echo 'class="thispage"';} ?>>Foto's</a></li>
        <li><a href="Bewoners.php" <?php if($active == 'bewoners') {echo 'class="thispage"';} ?>>Bewoners</a></li>
        <li><a href="Links.php" <?php if($active == 'links') {echo 'class="thispage"';} ?>>Links</a></li>
      </ul>
    </nav>
  </header>