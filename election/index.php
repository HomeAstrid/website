<?

define('MY_URL','http://astrid.ugent.be/election/UGCAS_Simple.php');

require_once('UGCAS_Simple.php');

session_start();

$user = $_SESSION['user'];

if (!$user) {
    $cas = new UGCAS_Simple(MY_URL);
    if ($ticket = $_GET['ticket']) {
        # returning from CAS
        $user = $cas->service_validate($ticket);
        if ($user) {
            $_SESSION['user'] = $user;
        }
        else {
            echo "<h1>ERROR</h1>\n";
            echo "<p>Authentication failed:\n";
            echo "<p>" . $cas->error;
            exit(0);
        }
    }
    else {
        # redirect to CAS
        $login_url = $cas->login_url();
        echo "<a href=\"$login_url\">login</a>";
        exit(0);
    }
}

echo "hello $user";
?>
