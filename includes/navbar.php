<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Maverick Custom Shop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?php if($fileName == 'index.php') echo 'active'; ?>" href="index.php">Produits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Panier</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($fileName == 'signup.php') echo 'active'; ?>" href="signup.php">Créer un compte</a>
          </li>
          <li class="nav-item">
            
            <?php if (!isset($_SESSION['userId'])) {
              echo "<a class='nav-link ";
              if($fileName == 'signin.php') echo 'active';
              echo "' href='signin.php'>Se connecter</a>";
            } else {
              echo "<a class='nav-link ";
              if($fileName == 'signin.php') echo 'active'; 
              echo "' href='signout.php'>Se déconnecter</a>";
            }
            ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>
