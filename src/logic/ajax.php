<?php 
    require '../class/World.cls.php';
    require '../class/WorldView.cls.php';
    require '../class/WorldControl.cls.php';

    $worldView = new WorldView();
    $worldControl = new WorldControl();

    if (isset($_POST["fillOut"])) {
        $code = $_POST["fillOut"];
        $country = json_encode($worldView->getCountryByCode($code));
        echo $country; 
    }


    if (isset($_POST["updateParameters"])) {
        $params = $_POST["updateParameters"];
        $worldControl->updateCountry($params);
    }

    if (isset($_POST["insertParameters"])) {
        $params = $_POST["insertParameters"];
        $worldControl->insertCountry($params);
    }

    if (isset($_POST["deleteParameters"])) {
        $params = $_POST["deleteParameters"];
        $worldControl->deleteCountry($params);
    }

    if (isset($_POST["searchParameters"])) {
        $name = $_POST["searchParameters"];
        $country = json_encode($worldView->searchCountry($name));
        echo $country;
    }

?>