<?php
include('sites/default/settings.php');

$host     = $databases['default']['default']['host'];
$database = $databases['default']['default']['database'];
$username = $databases['default']['default']['username'];
$password = $databases['default']['default']['password'];

//connection details
$connect = mysql_connect($host, $username, $password);
if (!$connect) {
    die('Could not connect to MySQL: ' . mysql_error());
}
//database name
$cid = mysql_select_db($database, $connect);

function import_csv($csv_file, $connect){
    if (($handle = fopen($csv_file, "r")) !== FALSE) {
        fgetcsv($handle);
        while (($data = fgetcsv($handle, 0, "\t")) !== FALSE) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                $col[$c] = $data[$c];
            }
            $col1  = $col[0];
            $col2  = $col[1];
            $col3  = $col[2];
            $col4  = $col[3];
            $col5  = $col[4];
            $col6  = $col[5];
            $col7  = $col[6];
            $col8  = $col[7];
            $col9  = $col[8];
            $col10 = $col[9];
            $col11 = $col[10];
            $col12 = $col[11];
            $col13 = $col[12];
            $col14 = $col[13];
            $col15 = $col[14];
            $col16 = $col[15];
            $col17 = $col[16];
            $col18 = $col[17];
            $col19 = $col[18];
            $col20 = $col[19];
            
            // SQL Query to insert data into Database
            $query = "INSERT INTO csv_soa(comp, customer_n, baseline, contract_no, bp_name, bp_org_name_1, buyer_name_1, buyer_name_2, email_address, project, be_name, unit, filename, birth_date, building_name, phase, unit_no, total_amt_due, total_amt_due_immediately, total_due_on) VALUES('" . $col1 . "','" . $col2 . "','" . $col3 . "','" . $col4 . "','" . $col5 . "','" . $col6 . "','" . $col7 . "','" . $col8 . "','" . $col9 . "','" . $col10 . "','" . $col11 . "','" . $col12 . "','" . $col13 . "','" . $col14 . "','" . $col15 . "','" . $col16 . "','" . $col17 . "','" . $col18 . "','" . $col19 . "','" . $col20 . "')";
            $s     = mysql_query($query, $connect);
        }
        fclose($handle);
    }
    echo "File data successfully imported to database!!";
}

//get list of csv files that were imported
$csvs   = array();
$sql    = 'SELECT * FROM csv_files';
$retval = mysql_query($sql, $connect);
while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
    array_push($csvs, $row['name']);
}

//import csv files that are not already imported
$csvfile = "";
if ($handle = opendir('csv')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'csv') {
            if (!in_array($file, $csvs)) {
                import_csv('csv/' . $file, $connect);
                $query = "INSERT INTO csv_files(name) VALUES('" . $file . "')";
                $s     = mysql_query($query, $connect);
            }
        }
    }
    closedir($handle);
}

mysql_close($connect);

?> 
