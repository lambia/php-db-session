<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "livecoding_mysqli");
define("DB_PORT", 3306);

$error = null;
$loggedUser = null;
$loginFailed = null;
$db = null;
$nome = null;
$pass = null;

if (isset($_GET["user"]) && isset($_GET["pass"])) {
    $nome = $_GET["user"];
    $pass = $_GET["pass"];
}

try {
    $db = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
} catch (Exception $e) {
    $error = "Eccezione durante la connessione al DB: " . $e->getMessage();
}

if ($error == null && $nome && $pass) {
    $query = $db->prepare("SELECT * FROM utenti WHERE nome  = ? AND password = ?");
    $query->bind_param("ss", $nome, $pass);
    $query->execute();
    $db_result = $query->get_result();

    if ($db_result->num_rows > 0) {
        $loggedUser = $db_result->fetch_assoc();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mySQLi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php if ($loggedUser) { ?>
        <h2>Benvenuto <?= $nome ?></h2>
    <?php } else {
        //header("Location: form.php");
    ?>
        <?php if ($nome && $pass) { ?>
            <div class="alert alert-danger" role="alert">Login failed!</div>
        <?php } ?>

        <?php if ($error) { ?>
            <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php } ?>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="privata.php" method="GET">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" class="form-control" name="user">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>