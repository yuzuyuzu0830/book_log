<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css/app.css">
    <title>読書ログ登録</title>
</head>
<body>
    <header div="header">
        <div class="container">
            <h1><a href="index.php">読書ログ</a></h1>
            <form action="create.php" method="post">
                <?php if(count($errors)): ?>
                    <ul>
                        <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
        </div>
    </header>
    <form>
        <div class="container">
            <h2>読書ログの登録</h2>
            <div>
                <label for="title">題名</label>
                <input type="text" name="title" id="title" value="<?php echo $review['title'] ?>">
            </div>
            <div>
                <label for="author">著者名</label>
                <input type="text" name="author" id="author" value="<?php echo $review['author'] ?>">
            </div>
            <div>
                <label>読書状況</label>
                <div>
                    <div>
                        <input type="radio" name="status" id="status1" value="未読" <?php echo($review['status'] === '未読') ? 'checked' : '' ?>>
                        <label for="status1">未読</label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="status2" value="読んでいる" <?php echo($review['status'] === '読んでいる') ? 'checked' : '' ?>>
                        <label for="status2">読んでいる</label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="status3" value="読了" checked <?php echo($review['status'] === '読了') ? 'checked' : '' ?>>
                        <label for="status3">読了</label>
                    </div>
                </div>
            </div>
            <div>
                <label for="score">評価(5点満点の整数)</label>
                <input type="number" name="score" id="score" value="<?php echo $review['score'] ?>">
            </div>
            <div>
                <label for="summary">感想</label>
                <textarea type="text" name="summary" id="summary" rows="10"><?php echo $review['summary'] ?></textarea>
            </div>
            <button type="submit">登録する</button>
        </div>
    </form>
</body>
</html>
