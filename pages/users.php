<?php 
  session_start();
  include_once('../api/api_calls.php');

  if($_SESSION['user']['isAdmin'] != true) {
      header('Location: ./home.php');
      exit();
  }

  $users = getUser();

  $adminUsers = getIngredients();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>M&M Retter</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars dark-mode" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="content">
                <h2>Admin Brugere</h2>
            </div>
            <div class="content text-right">
                <a href="#modal" class="btn btn-primary" role="button">Tilføj admin bruger</a>
            </div>
            <div class="card">
            <?php foreach ($users as $user) { if($user['isAdmin'] == true) { ?>
                <div class="alert filled-lm" style="margin-bottom:inherit" role="alert">
                    <form action="../scripts/delete.php" method="post">
                        <div class="form-group">
                            <label>Brugernavn</label>
                            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="**********" readonly="readonly">
                        </div>
                        <?php if($_SESSION['user']['isAdmin'] == true && $user['username'] != "mm_Admin") { ?>
                            <div class="form-group text-right">
                                <a href="#modal<?= $user['id'] ?>" class="btn btn-primary" role="button">Redigér</a>
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button class="btn btn-danger" type="submit" name="admin_delete_user"
                                        onclick="return confirm('Er du sikker på at du vil slette denne bruger?')">
                                    <i class="fas fa-trash"></i> Slet
                                </button>
                            </div>
                        <?php } ?>
                    </form>
                </div>
                <?php } } ?>
            </div>  

            <div class="content">
                <h2>Brugere</h2>
            </div>
            <div class="card">
            <?php foreach ($users as $user) { if($user['isAdmin'] != true) { ?>
                <div class="alert filled-lm" style="margin-bottom:inherit" role="alert">
                    <form action="../scripts/delete.php" method="post">
                        <div class="form-group">
                            <label>Brugernavn</label>
                            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="**********" readonly="readonly">
                        </div>
                        <div class="form-group text-right">
                            <a href="#modal<?= $user['id'] ?>" class="btn btn-primary" role="button">Redigér</a>
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button class="btn btn-danger" type="submit" name="admin_delete_user"
                                    onclick="return confirm('Er du sikker på at du vil slette denne bruger?')">
                                <i class="fas fa-trash"></i> Slet
                            </button>
                        </div>
                    </form>
                </div>
                <?php } } ?>
            </div>  
        </div>
    </div>
</div>

<!-- First modal -->
<?php
foreach($users as $user) {
?>
<div class="modal" id="modal<?= $user['id'] ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Redigering af brugeren: <u><?= $user['username'] ?></u></h5>
      <form action="../scripts/save_user_info.php" method="post">
        <div class="form-group">
            <label>Brugernavn</label>
            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?= $user['password'] ?>">
        </div>
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
        <input type="hidden" name="isAdmin" value="<?= $user['isAdmin'] ?>">
        <input class="btn btn-primary btn-block" type="submit" name="save_user_changes" value="Gem">
      </form>
    </div>
  </div>
</div>
<?php } ?>

<!-- Second modal -->
<div class="modal" id="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Tilføj admin bruger</h5>
      <form action="../scripts/create_admin_user.php" method="post">
        <div class="form-group">
            <label for="admin_username">Brugernavn</label>
            <input type="text" name="admin_username" id="admin_username" class="form-control">
        </div>
        <div class="form-group">
            <label for="admin_password">Password</label>
            <input type="password" name="admin_password" id="admin_password" class="form-control">
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="add_admin_user" value="Tilføj">
      </form>
    </div>
  </div>
</div>
</body>
</html>