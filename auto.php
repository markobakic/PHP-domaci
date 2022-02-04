    <?php
    include "broker.php";

    $broker = Broker::getBroker();

    if (isset($_GET["metoda"])) {
        if ($_GET["metoda"] == "vrati sve") {
            $broker->vratiSveAute();
            posalji($broker);
        }
        if ($_GET["metoda"] == "vrati iz salona") {
            $broker->vratiSveAuteIzSalona($_GET["salon"]);
            posalji($broker);
        }
        if ($_GET["metoda"] == "vrati kategorije") {
            $broker->vratiSveKategorije();
            posalji($broker);
        }
    }
    if (isset($_POST["metoda"])) {
        if ($_POST["metoda"] == "dodaj") {
            $naziv = $_POST["naziv"];
            $kategorija = $_POST["kategorija"];
            $brojAuta = $_POST["broj_auta"];
            if (!validirajAuto($naziv, $kategorija, $brojAuta)) {
                echo "auto nije validan";
            } else {
                $broker->dodajAuto($naziv, $kategorija, $brojAuta);
                if (!$broker->getRezultat()) {
                    echo "greska u bazi";
                } else {
                    echo "uspesno dodat auto";
                }
            }
        }

        if ($_POST["metoda"] == "izmeni") {
            $id = $_POST["id"];
            $naziv = $_POST["naziv"];
            $kategorija = $_POST["kategorija"];
            $brojAuta = $_POST["broj_auta"];
            if (!validirajAuto($naziv, $kategorija, $brojAuta)) {
                echo "Auto nije validan";
            } else {
                $broker->izmeniAuto($id, $naziv, $kategorija, $brojAuta);
                if (!$broker->getRezultat()) {
                    echo "greska u bazi";
                } else {
                    echo "uspesno izmenjen auto";
                }
            }
        }



        if ($_POST["metoda"] == "obrisi") {
            $broker->obrisiAuto($_POST["id"]);
            if (!$broker->getRezultat()) {
                echo "greska u bazi";
            } else {
                echo "uspesno obrisan auto";
            }
        }
    }





    function posalji($broker)
    {
        $rezultat = $broker->getRezultat();
        $response = array();
        if (!$rezultat) {
            $response["status"] = "greska u bazi";
        } else {
            $response["status"] = "ok";
            $response["data"] = array();
            while ($red = $rezultat->fetch_object()) {
                $response["data"][] = $red;
            }
        }
        echo json_encode($response);
    }

    function validirajAuto($naziv, $kategorija, $brojAuta)
    {
        $naziv = trim($naziv);
        $kategorija = trim($kategorija);
        $brojAuta = trim($brojAuta);
        return strlen($naziv) > 3 && strlen($naziv) < 40 && intval($kategorija) && intval($brojAuta);
    }

    ?>