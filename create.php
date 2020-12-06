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

    include 'views/new.php';
