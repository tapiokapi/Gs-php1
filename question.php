<!-- アンケート回答ページの表示 -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>演奏会アンケート</title>
  <link rel="stylesheet" href="css/question.css">
</head>
<body>
  <h1>演奏会アンケート回答ページ</h1>

  <form action="answer.php" method="post">
    <!-- 名前 -->
    <div class="question">
      <label for="name">名前：</label>
      <input type="text" name="user-name">
    </div>

    <!-- メールアドレス -->
    <div class="question">
      <label for="mail">Email：</label>
      <input type="email" name="user-mail">
    </div>

    <!-- 年齢 -->
    <div class="question">
      <label for="age">年齢：</label>
      <select name="age" id="age">
      <!-- 最初と最後のoption要素はHTMLで記述し、その他はfor文を使って出力する -->
        <option value="0" selected>お選びください</option>
        <?php
          for($num = 1; $num <= 7; $num++) {
            echo '<option value="' . $num .  '">' . $num . '0代</option>';
          }
        ?>
        <option value="8">80代以上</option>
      </select>
    </div>

    <!-- 性別 -->
    <div class="question">
      <label for="gender-list">性別：</label>
      <input type="radio" name="gender" value="1"> 男性
      <input type="radio" name="gender" value="2"> 女性
    </div>

    <!-- コンサートを知ったきっかけ -->
    <p class="title">Q1.コンサートを知ったきっかけ：</p>
    <?php
      // foreach文でチェックボックスを生成するため、$reasonでkey用配列を作る
      $reason = array(
        0 => "ポスター・チラシ",
        1 => "インターネット",
        2 => "SNS",
        3 => "知人からの勧め",
        4 => "団員からの勧め",
        5 => "その他");
      $ids = array('poster', 'internet', 'sns', 'friends', 'member', 'other');
      // チェックボックスをforeach文で生成する
      foreach($reason as $key => $value) {
        echo '<input
               type="checkbox"
               name="reason[]"
               value="' .$key . '" id="' . $ids[$key] .
              '">'. $value . "\n";
      }
    ?>

    <!-- 印象に残った曲 -->
    <p class="title">Q2.印象に残った曲：</p>
    <?php
      $music = array(
        0 => "ジャズ",
        1 => "ポップス",
        2 => "ロック");
      $ids = array('jazz', 'pops', 'rock');
      // チェックボックスをforeach文で生成する
      foreach($music as $key => $value) {
        echo '<input
               type="checkbox"
               name="music[]"
               value="' .$key . '" id="' . $ids[$key] .
              '">'. $value . "\n";
      }
    ?>

    <!-- ご感想 -->
    <p class="title">Q3.ご感想：</p>
    <textarea name="impressions" cols="40" rows="4"></textarea>
    <!-- 送信・リセットボタン -->
    <div>
      <input type="submit" class="btn btn-submit">
      <input type="reset" class="btn btn-reset">
    </div>
  </form>
</body>
</html>