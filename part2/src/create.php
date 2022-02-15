<?php
require_once __DIR__ . '/lib/mysqli.php';

function createReview($link, $review)
{
    $sql = <<<EOT
INSERT INTO reviews(
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
    if (!$result) {
        error_log('Error: fail to create review');
        error_log('Debugging Error:' . mysqli_error($link));
    }
}

function validate($review)
{
    $errors = [];
    $status_array = ['未読', '読んでいる', '読了'];

    //タイトル
    if (!mb_strlen($review['title'])) {
        $errors['title'] = 'タイトルを入力してください。';
    } elseif (mb_strlen($review['title']) > 255) {
        $errors['title'] = 'タイトルは255文字以内で入力してください。';
    }
    //著者名
    if (!mb_strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください。';
    } elseif (mb_strlen($review['author']) > 100) {
        $errors['author'] = '著者名は255文字以内で入力してください。';
    }
    //読書状況
    if (!in_array($review['status'], $status_array)) {
        $errors['status'] = '未読、読んでいる、読了のいづれかを入力してください。';
    }
    //評価
    if ((int)$review['score'] < 1 || (int)$review['score'] > 5) {
        $errors['score'] = '評価は1以上5以下の整数を入力してください。';
    }
    //感想
    if (!strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください。';
    } elseif (strlen($review['title']) > 255) {
        $errors['summary'] = '感想は1000文字以内で入力してください。';
    }

    return $errors;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //POSTされたレビューを変数に格納する
    if (!empty($_POST['status'])) {
        $status = $_POST['status'];
    } else {
        $status = '';
    }
    $review = [
        'title'   => $_POST['title'],
        'author'  => $_POST['author'],
        'status'  => $status,
        'score'   => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    //バリデーションする
    $errors = validate($review);
    if (!count($errors)) {
        //データベースに接続する
        $link = dbConnect();
        //データベースにデータを登録する
        createReview($link, $review);
        //データベースとの接続を切断する
        mysqli_close($link);
        header("Location: index.php");
    }
}

$title = '読書ログの登録';
$content = __DIR__ . '/views/new.php';

include 'views/layout.php';
