<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "livecoding_mysqli");
define("DB_PORT", 3306);

$error = null;
$result = null;
$db = null;

try {
    $db = @new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
} catch (Exception $e) {
    $error = "Eccezione durante la connessione al DB: " . $e->getMessage();
}

$nome = "luca";
$pass = "password-lunga";

$query = $db->prepare("SELECT * FROM utenti WHERE nome  = ? AND password = ?");
$query->bind_param("ss", $nome, $pass);
$query->execute();
$db_result = $query->get_result();

if ($db_result->num_rows > 0) {
    $result = $db_result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mySQLi</title>
</head>

<body>
    <?php
    if ($error != null) {
        echo "<h2>Error: $error</h2>";
    } else {
        var_dump($result);
    }
    ?>
</body>

</html>