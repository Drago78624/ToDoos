<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand text-info fs-3">Todoos!</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                <?php if(isset($_SESSION["signedin"])): ?>
                  <span class="text-info nav-item nav-link">Welcome <?php echo $_SESSION["name"]; ?>!</span>
                  <?php endif; ?>
                  <?php if(!isset($_SESSION["signedin"])): ?>
                    <a href="signin.php" class="nav-item nav-link">Sign in</a>
                    <a href="signup.php" class="nav-item nav- btn btn-info mx-3">Sign up</a>
                    <?php endif; ?>
                    <?php if(isset($_SESSION["signedin"])): ?>
                    <a href="signout.php" class="nav-item nav- btn btn-info mx-3">Sign out</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>