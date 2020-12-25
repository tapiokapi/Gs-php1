<!-- アンケート集計 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アンケート集計</title>
  <link rel="stylesheet" href="css/result.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
  
  <?php
  // アンケート結果を保存したテキストファイルを指定
  $textfile = './data/result.txt';
  // ファイルをオープン(rで読み込みモード, bで互換性維持)
  $fp = fopen($textfile, 'rb'); 
  
  if(!$fp) { //ファイルの存在有無チェック
    exit('ファイルが存在しません');
  }
  
  // ファイルポインタがEOF（最後）に達するまで、テキストの各行を読み出し、trim()で文字列の先頭および末尾にあるスペースを取り除き、配列に格納
  while(!feof($fp)) {
    $results[] = trim(fgets($fp));
  }
  
  // アンケート回答の総数が0でなければ、集計する
  if($results[19] != 0) {
    echo '<p class="title">アンケートの集計結果：総数　<span>' . $results[19] .'</span> 件</p>';
  }
  ?>

  <table>
    <thead>
      <tr>
        <th>質問</th>
        <th>人数</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>性別</td>
        <?php
          echo '<td>男性：' . $results[0] . '人<br>' . '女性：' . $results[1] . '人</td>';
        ?>
      </tr>
      <tr>
        <td>年齢</td>
        <?php
          echo '<td>10代：' . $results[2] . '人<br>' .
                   '20代：' . $results[3] . '人<br>' .
                   '30代：' . $results[4] . '人<br>' .
                   '40代：' . $results[5] . '人<br>' .
                   '50代：' . $results[6] . '人<br>' .
                   '60代：' . $results[7] . '人<br>' .
                   '70代：' . $results[8] . '人<br>' .
                   '80代以上：' . $results[9] . '人</td>';                
        ?>
      </tr>
      <tr>
        <td>コンサートを知ったきっかけ</td>
        <?php
          echo '<td>ポスター・チラシ：' . $results[10] . '人<br>' .
                   'インターネット：' . $results[11] . '人<br>' .
                   'SNS：' . $results[12] . '人<br>' .
                   '知人からの勧め：' . $results[13] . '人<br>' .
                   '団員からの勧め：' . $results[14] . '人<br>' .
                   'その他：' . $results[15] . '人</td>';
        ?>
      </tr>
      <tr>
        <td>印象に残った曲</td>
        <?php
          echo '<td>ジャズ：' . $results[16] . '人<br>' .
                   'ポップス：' . $results[17] . '人<br>' .
                   'ロック：' . $results[18] . '人</td>';
        ?>
      </tr>
    </tbody>
  </table>
  <!-- グラフ表示エリア -->
  <!-- 性別 -->
  <div style="position: absolute; top: 30px; left:550px; width:300px; height:300px;">
    <canvas id="myChart1" width="80" height="80"></canvas>
  </div>

  <!-- 年齢 -->
  <div style="position: absolute; top: 30px; left:950px; width:350px; height:350px;">
    <canvas id="myChart2" width="80" height="80"></canvas>
  </div>

  <!-- コンサートを知ったきっかけ -->
  <div style="position: absolute; top: 330px; left:530px; width:350px; height:350px;">
    <canvas id="myChart3" width="80" height="80"></canvas>
  </div>

  <!-- 印象に残った曲 -->
  <div style="position: absolute; top: 380px; left:950px; width:300px; height:300px;">
    <canvas id="myChart4" width="80" height="80"></canvas>
  </div>

  <!-- グラフ作成用にデータを加工 -->
  <?php
    // 性別
    $gender_data1 = array($results[0], $results[1]);
    // var_dump($gender_data1);
    $gender_data2 = [];
    foreach ($gender_data1 as $v) {
      $gender_data2[] = (int) $v; 
    }
    // var_dump($gender_data2);
    
    // 年齢
    $age_data1 = array($results[2], $results[3],  $results[4], $results[5], $results[6], $results[7], $results[8], $results[9]);
    // var_dump($age_data1);
    $age_data2 = [];
    foreach ($age_data1 as $v) {
      $age_data2[] = (int) $v; 
    }
    // var_dump($age_data2);

    // コンサートを知ったきっかけ
    $reason_data1 = array($results[10], $results[11],  $results[12], $results[13], $results[14], $results[15]);
    // var_dump($reason_data1);
    $reason_data2 = [];
    foreach ($reason_data1 as $v) {
      $reason_data2[] = (int) $v; 
    }
    // var_dump($reason_data2);

    // コンサートを知ったきっかけ
    $music_data1 = array($results[16], $results[17],  $results[18]);
    // var_dump($music_data1);
    $music_data2 = [];
    foreach ($music_data1 as $v) {
      $music_data2[] = (int) $v; 
    }
    // var_dump($music_data2);

    fclose($fp);
    echo '<p class="link"><a href="question.php">アンケート回答ページへ戻る</a></p>';
  ?>
  <script>
    // phpからの値を受け取る
    // 性別
    let genderArr = <?php echo json_encode($gender_data2, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    console.log(genderArr);

    // 年齢
    let ageArr = <?php echo json_encode($age_data2, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    // コンサートを知ったきっかけ
    let reasonArr = <?php echo json_encode($reason_data2, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    // 印象に残った曲
    let musicArr = <?php echo json_encode($music_data2, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    // グラフの描画処理
    // 性別
    let ctx1 = document.getElementById("myChart1").getContext('2d');
    let genderChart = new Chart(ctx1, {
      type: 'pie',
      data: {
        labels: ["男性", "女性"],
        datasets: [{
          label: '男女の人数',
          data: genderArr,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255,99,132,1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        title: {
            display: true,
            text: '男女の人数',
            fontSize: 18
        }
      }
    });
    // 年齢
    let ctx2 = document.getElementById("myChart2").getContext('2d');
    let ageChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ["10代", "20代", "30代", "40代", "50代", "60代", "70代", "80代以上"],
        datasets: [{
          label: '年齢',
          data: ageArr,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 0.2)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(54, 162, 235, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        title: {
            display: true,
            text: '来場者の年齢層',
            fontSize: 18
        }
      }
    });
    // コンサートを知ったきっかけ
    let ctx3 = document.getElementById("myChart3").getContext('2d');
    let reasonChart = new Chart(ctx3, {
      type: 'pie',
      data: {
        labels: ["ポスター・チラシ", "インターネット", "SNS", "知人からの勧め", "団員からの勧め", "その他"],
        datasets: [{
          label: 'コンサートを知ったきっかけ',
          data: reasonArr,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 165, 0, 0.2)',
            'rgba(255, 255, 0, 0.2)',
            'rgba(0, 128, 0, 0.2)',
            'rgba(0, 255, 255, 0.2)',
            'rgba(128, 0, 128, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 165, 0, 1)',
            'rgba(252, 200, 0, 1)',
            'rgba(0, 128, 0, 1)',
            'rgba(0, 175, 204, 1)',
            'rgba(128, 0, 128, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        title: {
            display: true,
            text: 'コンサートを知ったきっかけ',
            fontSize: 18
        }
      }
    });
    // 印象に残った曲
    let ctx4 = document.getElementById("myChart4").getContext('2d');
    let musicChart = new Chart(ctx4, {
      type: 'pie',
      data: {
        labels: ["ジャズ", "ポップス", "ロック"],
        datasets: [{
          label: '印象に残った曲',
          data: musicArr,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 165, 0, 0.2)',
            'rgba(255, 255, 0, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 165, 0, 1)',
            'rgba(252, 200, 0, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        title: {
            display: true,
            text: '印象に残った曲',
            fontSize: 18
        }
      }
    });
  </script>
</body>
</html>