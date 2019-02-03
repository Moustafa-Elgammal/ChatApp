<?php
require_once('./../config.php');
if (!auth()) {
    die("<pre>   <br>    No Access. <a href='index.php'>Home</a> </pre>");
}
$messenger = new messages($db->connection());
$messages = $messenger->getMessages();
$content = "";

$filename = 'db.csv';
$fp = fopen($filename, 'w');
$i = 0;
$records_arr  = [];
$keys  = [];
foreach ($messages as $record) {

    $record_arr = array();

    foreach ($record as $key => $value) {
        if (strlen($key)> 1){
            $record_arr[] = $value;
        }
    }

    if($i == 0){
        foreach (array_keys((array)$record) as $key)
            if (strlen($key)> 1)
                $keys [] = $key;

        fputcsv($fp, $keys);
    }

    fputcsv($fp, array_values($record_arr));
    $i++;
}

fclose($fp);

forceDownload($filename,"application/octet-stream");

echo file_get_contents($filename);


