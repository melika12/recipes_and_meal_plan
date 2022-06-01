<?php
    error_reporting(0);
?>
<nav class="navbar">
    <div class="navbar-content">
        <form class="form-inline ml-auto" action="../scripts/find_meal.php" method="get">
            <div class="search-box">
                <input list="names" type="text" class="form-control w-300" autocomplete="off" name="search"
                       placeholder="Search for meal">
                <datalist id="names" class="result"></datalist>
            </div>
        </form>
    </div>
    <ul class="navbar-nav ml-auto mr-15">
        <li class="nav-item">
            <a href="./home.php" class="nav-link">Retter</a>
        </li>
        <?php if($_SESSION['user']['isAdmin'] == true) { ?>
            <li class="nav-item">
                <a href="./requests.php" class="nav-link">Anmodninger</a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="./ingredient.php" class="nav-link">Ingredienser</a>
        </li>
        <li class="nav-item">
            <a href="./amount.php" class="nav-link">Måleenheder</a>
        </li>
        <?php if(!$_SESSION['user']) { ?>
        <li class="nav-item">
            <a href="./login.php" class="nav-link">Login</a>
        </li>
        <?php } ?>
        <?php if($_SESSION['user']) { ?>
        <li class="nav-item dropdown with-arrow">
            <a class="nav-link" data-toggle="dropdown" id="nav-link-dropdown-toggle">
                <?= $_SESSION['user']['username'] ?>
                <i class="fa fa-angle-down ml-5" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-link-dropdown-toggle">
                <a href="./settings.php" class="dropdown-item">Settings</a>
                <a href="../scripts/logout.php" class="dropdown-item">Log out</a>
            </div>
        </li>
        <?php } ?>
    </ul>
</nav>
<script>
    $(document).ready(function () {
        $('.search-box input[type="text"]').on('keyup input', function () {

            /* Get input value on change */
            let inputVal = $(this).val();
            let resultDropdown = $(this).siblings(".result");
            if (inputVal.length) {

                $.get("../scripts/search_bar.php", {search: inputVal}).done(function (data) {
                    // Display the returned data in browser
                    console.log(data);
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on('click', '.result p', function () {
            $(this).parents('.search-box').find('input[type="text"]').val($(this).text());
            $(this).parent('.result').empty();
        });
    });
</script>