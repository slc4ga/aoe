<?
    require_once '../nav/mysql.php';
    session_start();

    $mysql = new Mysql();

    $id = $_GET['select'];
    $pc = $mysql->getPledgeClass($id);


    if( strpos($pc,'Alumnae') !== false) {
        $pc = 'alum';
    }
    $pc = strtolower($pc);
    echo $pc . "Li";
?>