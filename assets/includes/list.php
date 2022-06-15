<?php
require_once "connect.php";
function liste(){


    $einkaufdb = geteinkaufDB();


    # Abfrage der Daten
    function abfrage(){
        global $einkaufdb;
        $abfrage = $einkaufdb->query("SELECT * FROM einkauf WHERE checked = '' ORDER BY ListeID DESC ");
        return $abfrage;
    }
    function abfrageChecked(){
        global $einkaufdb;
        $abfrage = $einkaufdb->query("SELECT * FROM einkauf WHERE checked = 'checked' ORDER BY ListeID DESC ");
        return $abfrage;
    }


    ob_start(); ?>
<br>
    <div class="row">
        <form id="newArtikelForm" action="" method="post">
            <div class="row">
                <div class="col-6 col-input">
                    <div class="input-group input-group-dynamic mb-4 col-4">
                        <input id="artikel" autocomplete="off" class="form-control" name="artikel" placeholder="Artikel">
                    </div>
                </div>
                <div class="col-1">
                    <label></label>
                    <br>
                    <input id="add" type="submit" value="+" name="add" class="btn btn-plus btn-primary btn-md">

                </div>
            </div>
        </form>
    </div>
    <form action="assets/functionsPHP/leeren.php" method="post">
        <div class="row mt-2">
            <div class="col-12 ">
                <input class="btn btn-danger btn-md"" type="submit" name="leeren" value="Liste leeren">
            </div>
        </div>
    </form>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <!--<th scope="col">ID</th>-->
        <th scope="row">Artikel</th>
        <th scope="row">Anzahl</th>
        <th scope="row">Checked</th>
    </tr>
    </thead>
    <tbody>
    <!-- Listen Start HTML -->

    <?php
    $abfrage = abfrage();
    foreach ($abfrage AS $item ) :?>
        <tr>
            <td class="table-item-name">
                <?php echo $item["Name"] ?></td>
            <td>
                <form name="anzahlInputForm" class="anzahlInputForm" method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $item["ListeID"] ?>">
                    <input  type="text" autocomplete="off" class="anzahlInput" name="anzahl-<?php echo $item["ListeID"]; ?>" value="<?php echo $item["Anzahl"] ?>">
                </form>
            </td>
            <td><form method="post" action="../../index.php" >
                    <input name="id" type="hidden" id="id" value="<?php echo $item["ListeID"] ?>">
                    <div class="form-check">
                        <input value="<?php echo $item["ListeID"] ?>" name="checked" class="form-check-input checkedSent" <?php echo $item["checked"] ?>    type="checkbox">
                    </div>
                </form></td>
        </tr>
    <?php endforeach;?>



    <!-- Listen Ende HTML -->
    <tr>
        <th scope="row"></th>
        <th scope="row"></th>
        <th scope="row"></th>
    </tr>
    </thead>
    <tbody>
    <!-- Listen Start HTML -->


    <!-- Checked Liste PHP -->
    <?php
    $abfrage = abfrageChecked();
    foreach ($abfrage AS $item ) :?>
        <tr class="table-grey">
            <td class="table-item-name"><?php echo $item["Name"] ?></td>
            <td>
                <form class="anzahlInputForm" method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $item["ListeID"] ?>">
                    <input  type="text" autocomplete="off" class="anzahlInput" name="anzahl-<?php echo $item["ListeID"]; ?>" value="<?php echo $item["Anzahl"] ?>">
                </form>
            </td>
            <td><form method="post" action="../../index.php" >
                    <input name="id" type="hidden" id="id" value=" <?php echo $item["ListeID"] ?>">
                    <div class="form-check">
                        <input class="form-check-input uncheckedSent" value="<?php echo $item["ListeID"] ?>" name="notchecked" <?php echo $item["checked"] ?> type="checkbox">
                    </div>
                </form></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<script src="assets/js/artikel.js"></script>

  <?php return ob_get_clean();
    }
    ?>