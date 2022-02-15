<?php

function validate($review)
{
    $errors = [];
    $status_array = ['未読', '読んでいる', '読了'];

    //書籍名が正しく入力されているか確認
    if (!mb_strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください。' . PHP_EOL;
    } elseif (mb_strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください。' . PHP_EOL;
    }

    //著者名が正しく入力されているか確認
    if (!mb_strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください。' . PHP_EOL;
    } elseif (mb_strlen($review['author']) > 255) {
        $errors['author'] = '書籍名は255文字いないで入力してください。' . PHP_EOL;
    }

    //読書状況が正しく入力されているか確認
    if (in_array($review['status'], $status_array)) {
        $errors['status'] = '未読、読んでいる、読了のいづれかを入力してください。' . PHP_EOL;
    }

    //評価が正しく入力されているか確認
    if (!(int)$review['evaluation']) {
        $errors['evaluation'] = '整数を入力してください。' . PHP_EOL;
    } elseif (((int)$review['evaluation'] < 1) || ((int)$review['evaluation'] > 5)) {
        $errors['evaluation'] = '評価は1以上5以下の整数を入力してください。' . PHP_EOL;
    }

    //感想が正しく入力されているか確認
    if (!mb_strlen($review['impression'])) {
        $errors['impression'] = '書籍名を入力してください。' . PHP_EOL;
    } elseif (mb_strlen($review['impression']) > 1000) {
        $errors['impression'] = '書籍名は1000文字以内で入力してください。' . PHP_EOL;
    }

    return $errors;
}

function createReview($link)
{
    $review = [];

    echo '読書ログを登録してください。' . PHP_EOL;
    echo '書籍名：';
    $review['title'] = trim(fgets(STDIN));
    echo '著者名：';
    $review['author'] = trim(fgets(STDIN));
    echo '読書状況（未読,読んでる,読了）：';
    $review['status'] = trim(fgets(STDIN));
    echo '評価（5点満点の整数）：';
    $review['evaluation'] = trim(fgets(STDIN));
    echo '感想：';
    $review['impression'] = trim(fgets(STDIN));

    $validated = validate($review);
    if (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error;
        }
        return;
    }

    $sql = <<<EOT
    INSERT INTO book_log(
        title,
        author,
        status,
        evaluation,
        impression
    )VALUES(
        "{$review['title']}",
        "{$review['author']}",
        "{$review['status']}",
        "{$review['evaluation']}",
        "{$review['impression']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録が完了しました。' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error:データの追加に失敗しました。' . PHP_EOL;
        echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

function listReviews($link)
{
    $sql = 'SELECT title, author, status, evaluation, impression FROM book_log';
    $results = mysqli_query($link, $sql);
    while ($review = mysqli_fetch_assoc($results)) {
        echo '読書ログを表示します。' . PHP_EOL;
        echo '書籍名:' . $review['title'] . PHP_EOL;
        echo '著者名:' . $review['author'] . PHP_EOL;
        echo '読書状況（未読,読んでる,読了）：' . $review['status'] . PHP_EOL;
        echo '評価（5点満点の整数）：' . $review['evaluation'] . PHP_EOL;
        echo '感想:' . $review['impression'] . PHP_EOL;
        echo '-----------------------------------------' . PHP_EOL;
    }
    mysqli_free_result($results);
}

function connectMySQL()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    if (!$link) {
        echo 'Error:データベースに接続できませんでした' . PHP_EOL;
        echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
        exit;
    } else {
        echo 'データベースに接続できました。' . PHP_EOL;
    }
    return $link;
}

function disconnectMySQL($link)
{
    mysqli_close($link);
    echo 'データベースとの接続を切断しました。' . PHP_EOL;
}


$title = '';
$author = '';
$status = '';
$evaluation = '';
$impression = '';


$link = connectMySQL();

while (1) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください。（1,2,9）' . PHP_EOL;
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        //読書録を登録する
        $reviews[] = createReview($link);
    } elseif ($num === '2') {
        //読書ログを表示
        listReviews($link);
    } elseif ($num === '9') {
        //アプリケーションを終了する
        disconnectMySQL($link);
        echo PHP_EOL;
        break;
    }
}

/*
echo '読書ログを登録してください。' . PHP_EOL;
echo '書籍名：';
$title = trim(fgets(STDIN));
echo '著者名：';
$author = trim(fgets(STDIN));
echo '読書状況（未読,読んでる,読了）：';
$status = trim(fgets(STDIN));
echo '評価（5点満点の整数）：';
$evaluation = trim(fgets(STDIN));
echo '感想：';
$impression = trim(fgets(STDIN));

echo '登録が完了しました。' . PHP_EOL . PHP_EOL;
echo '読書ログを表示します。' . PHP_EOL;
echo '書籍名:' . $title . PHP_EOL;
echo '著者名:' . $author . PHP_EOL;
echo '読書状況（未読,読んでる,読了）：' . $status . PHP_EOL;
echo '評価（5点満点の整数）：' . $evaluation . PHP_EOL;
echo '感想:' . $impression . PHP_EOL;
*/

//echo '書籍名：銀河鉄道の夜' . PHP_EOL;
//echo '著者名：宮沢賢治' . PHP_EOL;
//echo '読書状況：読了' . PHP_EOL;
//echo '評価：５' . PHP_EOL;
//echo '感想：本当の幸せとはんだろうかと考えさせられる作品だった。' . PHP_EOL;
