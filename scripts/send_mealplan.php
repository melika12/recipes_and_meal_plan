<?php
include_once('../api/api_calls.php');
$days = getweekdays();

//Send email
if (isset($_POST['email']) || isset($_POST['emailaddress'])) {
    //the email address
    $mail = (isset($_POST['mail'])) ? $_POST['mail'] : $_POST['mailaddress_mealplan'];

    // The message
    $txt = ' 
    <html> 
    <head> 
        <title>Madplan oprettet d. '.date("d/m-Y").'</title> 
    </head> 
    <body> 
        <h1>Hermed madplan for ugens løb</h1> 
        <table cellspacing="0" style="width: 50%;">'; 
        
    foreach ($days as $day) {
    $txt .= '
    <tr> 
    <th>'.$day['name'].':</th><td>'.$_POST[''.$day['name'].''].'</td> 
    </tr> 
    ';
    }

    $txt .= '</table> 
    </body> 
    </html>'; 
    
    // Additional headers 
    $subject = "Madplan oprettet d. ".date("d/m-Y");
    $headers = "From: Madplan <madplan@madplan.localdomain>";

    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

    // Send email 
    if(mail($mail, $subject, $txt, $headers)){ 
        header('Location: ../pages/home.php');
    }else{ 
        echo "<script>
        alert('Emailen blev ikke sendt');
        </script>";
        header('Location: ../pages/home.php');
    }
}

//Add to calendar
if (isset($_POST['calendar']) || isset($_POST['add_calendar'])) {
    include '../modules/ICS.php';
    $txt ="";
    // The message
    foreach ($days as $day) {
        $txt .= $day['name'].': '.$_POST[''.$day['name'].''].'\n';
    }

    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=madplan.ics');
    $start_date = date("d-m-Y", strtotime("+1 day"));
    $end_date = date("d-m-Y", strtotime("+7 day"));
    //UTC time
    $time = "5:00PM";
    // create ics file
    $ics = new ICS(array(
    'location' => "",
    'description' => $txt,
    'dtstart' => $start_date.' '.$time,
    'dtend' => $end_date.' '.$time,
    'summary' => "Madplan fra d. ".$start_date." til d. ".$end_date,
    'url' => "http://madplan.mynster-it.dk"
    ));
    echo $ics->to_string();
}