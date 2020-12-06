<?php

require_once __DIR__ . '/lib/mysqli.php';

function createReview($link, $review) {
    $sql = <<<EOT
    INSERT INTO reviews (
        title,
        author,
        status,
        score,
        summary
    ) VALUES (
        "{$review['title']}",
        "{$review['author']}",
        "{$review['status']}",
        "{$review['score']}",
        "{$review['summary']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if(!$result) {
        error_log('Error: fail to create review');
        error_log ('Debugging Error: ' . mysqli_error($link));
    }
}

function validate($review) {
    $errors = [];

    if(!strlen($review['title'])) {
        $errors['title'] = 'タイトルを入力してください';
    } else if(strlen($review['title']) > 255) {
        $errors['title'] = 'タイトルは255文字以内で入力してください';
    }

    if(!strlen($review['author'])) {
        $errors['author'] = '著者を入力してください';
    } else if(strlen($review['author']) > 100) {
        $errors['author'] = '著者は100文字以内で入力してください';
    }

    if(!is_numeric($review['score'])) {
        $errors['score'] = '評価を入力してください';
    } elseif ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '評価は1~5段階評価で入力してください';
    }

    if(strlen($review['summary']) > 10000) {
        $errors['summary'] = '感想は10,000文字以内で入力してください';
    }

    return $errors;

}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $_POST['status'],
        'score' => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    // バリデーションをする
    $errors = validate($review);

    if(!count($errors)) {
        $link = dbConnect();
        createReview($link, $review);
        mysqli_close($link);
        header("Location: index.php");
    }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログ登録</title>
</head>
<body>
    <h1>読書ログ</h1>
    <form action="create.php" method="post">
        <?php if(count($errors)): ?>
            <ul>
                <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div>
            <label for="title">題名</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" name="author" id="author">
        </div>
        <div>
            <label>読書状況</label>
            <div>
                <div>
                    <input type="radio" name="status" id="status1" value="未読">
                    <label for="status1">未読</label>
                </div>
                <div>
                    <input type="radio" name="status" id="status2" value="読んでいる">
                    <label for="status2">読んでいる</label>
                </div>
                <div>
                    <input type="radio" name="status" id="status3" value="読了" checked>
                    <label for="status3">読了</label>
                </div>
            </div>
        </div>
        <div>
            <label for="score">評価(5点満点の整数)</label>
            <input type="number" name="score" id="score">
        </div>
        <div>
            <label for="summary">感想</label>
            <textarea type="text" name="summary" id="summary" rows="10"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>
</body>
</html>
