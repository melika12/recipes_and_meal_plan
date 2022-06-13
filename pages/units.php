<?php
    session_start();
    include_once('../api/api_calls.php');

    $data = getUnits();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>M&M Måleenheder</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="content">
                <h2>Måleenheder</h2>
            </div>
            <div class="content text-right">
            <?php if ($_SESSION['user']) { ?>
              <a href="#modal-1" class="btn btn-primary" role="button"><?= ($_SESSION['user']['isAdmin']) ? 'Tilføj ny måleenhed' : 'Anmodning om ny måleenhed' ?></a>
            <?php } ?>
            </div>
            <div class="card">
                <div class="row">
                    <?php foreach ($data as $d) { ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 px-5 pb-5">
                        <form action="../scripts/delete.php" method="post">
                            <table class="table" style="border: 2px solid grey;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <?= $d['name'] ?>
                                        </td>
                                        <?php if($_SESSION['user'] && $_SESSION['user']['isAdmin'] == true) { ?>
                                            <td class="text-right">
                                                <button class="btn btn-danger" type="submit" name="delete_unit" onclick="return confirm('Er du sikker på at du vil slette denne måleenhed?')">
                                                  <i class="fas fa-user-times"></i> Slet
                                                </button>
                                            </td>
                                        <?php } ?>
                                        <input type="hidden" name="unit_id" value="<?= $d['id'] ?>">
                                    </tr>
                                </tbody>
                            </table>
                        </form> 
                    </div>
                    <?php } ?>
                </div> 
            </div>
        </div>
    </div>
</div>

<!-- First comes the modal -->
<div class="modal" id="modal-1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title"><?= ($_SESSION['user']['isAdmin']) ? 'Tilføj ny måleenhed' : 'Anmodning til ny måleenhed' ?></h5>
      <form action="../scripts/request_or_add.php" method="post">
        <div class="form-group">
          <label for="unit" class="required">Måleenhed</label>
          <input type="text" id="unit" name="unit" class="form-control" placeholder="Måleenhed" required="required">
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="request_unit" value="<?= ($_SESSION['user']['isAdmin']) ? 'Tilføj måleenhed' : 'Indsend Anmodning' ?>">
      </form>
    </div>
  </div>
</div>
</body>
</html>