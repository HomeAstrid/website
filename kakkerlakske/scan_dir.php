<?php
// scan de dir (vind alle bestanden)
$files = scandir('./uploads/');
$array = [];
// overloop en zoek de pdf's
foreach ($files as $file) {
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if ($ext == 'pdf') {
        $elem = new StdClass();
        $elem->url = "http://astrid.ugent.be/kakkerlakske/uploads/" . $file;
        array_push($array, $elem);
    }
}
echo json_encode($array);