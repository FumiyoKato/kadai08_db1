<?php
// 1. POSTデータ取得
$company_name = $_POST["company_name"];
$fctunit_name = $_POST["fctunit_name"]; 
$pv_capacity = $_POST["pv_capacity"];
$pcs_capacity = $_POST["pcs_capacity"];
$direction = $_POST["direction"];
$angle = $_POST["angle"];
$pcs_efficiency = $_POST["pcs_efficiency"];
$lossrate = $_POST["lossrate"];
$prefecture = $_POST["prefecture"];
$primary_wxarea = $_POST["primary_wxarea"];

// 2. DB接続します
try {
    $pdo = new PDO('mysql:dbname=pvfctdb_test0;charset=utf8;host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを例外に設定
} catch (PDOException $e) {
    exit('DB_CONNECT:'.$e->getMessage()); // エラーメッセージ表示
}

// 3. データ登録SQL作成
try {
    $sql = "INSERT INTO pvfct_setting(id,company_name,fctunit_name,pv_capacity,pcs_capacity,direction,angle,pcs_efficiency,lossrate,prefecture,primary_wxarea,indate)
            VALUES(NULL, :company_name, :fctunit_name, :pv_capacity, :pcs_capacity, :direction, :angle, :pcs_efficiency, :lossrate, :prefecture, :primary_wxarea, sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);  // バインド変数でハッキング等を阻止
    $stmt->bindValue(':fctunit_name', $fctunit_name, PDO::PARAM_STR);  // Srting（文字列の場合 PDO::PARAM_STR)
    $stmt->bindValue(':pv_capacity', $pv_capacity, PDO::PARAM_INT);  // Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':pcs_capacity', $pcs_capacity, PDO::PARAM_INT);
    $stmt->bindValue(':direction', $direction, PDO::PARAM_INT);
    $stmt->bindValue(':angle', $angle, PDO::PARAM_INT);
    $stmt->bindValue(':pcs_efficiency', $pcs_efficiency, PDO::PARAM_INT);
    $stmt->bindValue(':lossrate', $lossrate, PDO::PARAM_INT);
    $stmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
    $stmt->bindValue(':primary_wxarea', $primary_wxarea, PDO::PARAM_STR);
    $status = $stmt->execute(); // true or false
} catch (PDOException $e) {
    exit("SQL_ERROR:".$e->getMessage()); // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
}

// 4. データ登録処理後
if($status === false){
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
}else{
    header("Location: index.php");
    exit();
}
?>
