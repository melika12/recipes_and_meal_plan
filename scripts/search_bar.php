<?php
    require('../api/api_calls.php');

    if(isset($_REQUEST['search'])) {
        $searchq = $_REQUEST['search'];
        $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

        $searching = getRecipeByName($searchq);
        echo "<option>" . $searching["name"] . "</option>";
    }
?>