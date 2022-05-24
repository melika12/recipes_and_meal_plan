<!DOCTYPE html>
<html lang="da">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Include the above in your HEAD tag -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="../style/style.css" rel="stylesheet">
    <script src="../js/script.js"></script>
    <head>
        <title>M&Ms madplan</title>
        <meta charset="UTF-8">
    </head>
    <?php 
        include('recipes.php');
    ?> 
    <body>
        <header class="site-header sticky-top py-1 bg-dark">
            <nav class="container d-flex flex-column flex-md-row justify-content-between">
                <a type="button" class="btn btn-primary" href="./home.php">Retter</a>
                <a type="button" class="btn btn-primary" href="./ingredient.php">Ingredienser</a>
                <a type="button" class="btn btn-primary" href="./amount.php">Måleenheder</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Opret madplan</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Generere madplan</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Indstillinger</button>
                <a type="button" class="btn btn-primary" href="./login.php">Login</a>
            </nav>
        </header>