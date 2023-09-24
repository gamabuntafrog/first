<?php

//  Асоціативний масив “Новини” 
// (Код, заголовок новини, короткий зміст новини, текст новини, дата публікації, кількість переглядів). 
// Запит на новини з кількістю переглядів не меше Х, за вказану дату.

function echoAlert($text)
{
    echo "<script type=\"text/javascript\">alert(\"$text\");</script>";
}

$currentDate = date('Y-m-d');

$news = [
    [
        'code' => 1,
        'title' => "Новина 1",
        'description' => "Опис новини 1",
        'text' => "Текст новини 1",
        'date' => date('Y-m-d', strtotime($currentDate . rand(-100, -1))),
        'watchCount' => rand(1, 100),
    ],
    [
        'code' => 2,
        'title' => "Новина 2",
        'description' => "Опис новини 2",
        'text' => "Текст новини 2",
        'date' => date('Y-m-d', strtotime($currentDate . rand(-100, -1))),
        'watchCount' => rand(1, 100),
    ],
    [
        'code' => 3,
        'title' => "Новина 1",
        'description' => "Опис новини 3",
        'text' => "Текст новини 3",
        'date' => date('Y-m-d', strtotime($currentDate . rand(-100, -1))),
        'watchCount' => rand(1, 100),
    ],
    [
        'code' => 4,
        'title' => "Новина 4",
        'description' => "Опис новини 4",
        'text' => "Текст новини 4",
        'date' => date('Y-m-d', strtotime($currentDate . rand(-100, -1))),
        'watchCount' => rand(1, 100),
    ],
    [
        'code' => 5,
        'title' => "Новина 5",
        'description' => "Опис новини 5",
        'text' => "Текст новини 5",
        'date' => date('Y-m-d', strtotime($currentDate . rand(-100, -1))),
        'watchCount' => rand(1, 100),
    ],
];

if (isset($_POST['createNews'])) {
    $news[] = [
        'code' => $_POST['code'] ?? '',
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'text' => $_POST['text'] ?? '',
        'date' => date("Y-m-d"),
        'watchCount' => rand(1, 100),
    ];
}

if (isset($_POST['editNews'])) {
    $wasFound = false;

    foreach ($news as $key => $obj) {
        if ($obj['code'] == $_POST['code']) {
            $wasFound = true;

            $news[$key] = [
                ...$news[$key],
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'text' => $_POST['text'] ?? '',
            ];
        }
    }

    if (!$wasFound) {
        echoAlert("News not found");
    }
}

$news = array_filter($news, function ($element) {
    $return_flag = true;

    if (isset($_GET['title']) && !strpos($element['title'], $_GET['title'])) {
        $return_flag = false;
    }

    if (isset($_GET['description']) && !strpos($element['description'], $_GET['description'])) {
        $return_flag = false;
    }

    if (isset($_GET['text']) && !strpos($element['text'], $_GET['text'])) {
        $return_flag = false;
    }

    if (isset($_GET['date']) && new DateTime($element['date']) < new DateTime($_GET['date'])) {
        $return_flag = false;
    }

    if (isset($_GET['minWatchCount']) && $element['watchCount'] < $_GET['minWatchCount']) {
        $return_flag = false;
    }

    return $return_flag;
});

include 'templates/news_table.phtml';
include 'templates/news_create.phtml';
include 'templates/news_edit.phtml';
