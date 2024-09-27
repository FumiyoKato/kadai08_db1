<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=pvfctdb_test0;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONNECT:'.$e->getMessage());
}

//2. データ取得SQL作成
$sql = "SELECT * FROM pvfct_setting";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

//3. データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSON値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PV予測設定一覧</title>
  <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th {
        background-color: #f0f0f0; /* 薄いグレー色 */
        font-weight: bold;
        padding: 8px;
    }

    td {
        padding: 8px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9; /* 偶数行に薄い背景色をつける */
    }
  </style>
</head>
<body>
  <h1><a href="index.php">PV予測対象一覧</a></h1>
  <?php
    if (!empty($values)) {
      echo '<table>';
      
      // カラムヘッダーの処理
      echo '<tr>';
      foreach (array_keys($values[0]) as $header) {
          echo '<th>' . htmlspecialchars($header) . '</th>';
      }
      echo '</tr>';

      // データの処理
      foreach ($values as $row) {
          echo '<tr>';
          foreach ($row as $cell) {
              echo '<td>' . htmlspecialchars($cell) . '</td>';
          }
          echo '</tr>';
      }

      echo '</table>';
  } else {
      echo "<p>データベースにデータがありません。</p>";
  }
  ?>

<script>
  //JSON受け取り
  const jsonData = '<?= $json ?>';
  const obj = JSON.parse(jsonData);
  console.log(obj);
</script>
</body>
</html>
