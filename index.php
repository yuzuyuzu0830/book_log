<?php
require_once __DIR__ . '/lib/mysqli.php';

function linkBooks($link) {
    $books = [];
    $sql= 'SELECT title, author, status, score, summary FROM reviews';
    $results = mysqli_query($link, $sql);

    while($book = mysqli_fetch_assoc($results)) {
        $books[] = $book;
    }
    mysqli_free_result($results);

    return $books;
}

$link = dbConnect();
$books = linkBooks($link);


$title = '読書ログ';
$content = __DIR__ . '/views/index.php';

include __DIR__ . '/views/layout.php';
