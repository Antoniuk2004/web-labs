<?php
include "data.php";

// sleep(5);

$productName = $_GET["name"];
$pageNumber = $_GET["pageNumber"];

const data = new Data();

$arr_of_values = data->getData($pageNumber, $productName);

$arrOfImages = $arr_of_values["arrOfImages"];
$arrOfTitles = $arr_of_values["arrOfTitles"];
$arrOfPrices = $arr_of_values["arrOfPrices"];
$arrOfDescriptions = $arr_of_values["arrOfDescriptions"];
$numberOfPages = $arr_of_values["numberOfPages"];

if ($arrOfTitles) {
    renderNormalList($arrOfPrices, $arrOfImages, $arrOfTitles, $arrOfDescriptions);
    renderPageContainer($numberOfPages, $pageNumber);
} else {
    renderNothingFound();
}

function renderNothingFound()
{
    echo "
    <div class='nothing-found'>
                <p>По вашому запиту нічого не знайдено.</p>
            </div>
    ";
}

function renderNormalList($arrOfPrices, $arrOfImages, $arrOfTitles, $arrOfDescriptions)
{
    echo "<div id='goods-block' class='goods-block'>";
    for ($i = 0; $i < sizeof($arrOfPrices); $i++) {
        echo "
    <div class='goods-block-item'>
        <div class='image-container'>
            <a href='#'>
                <img src='{$arrOfImages[$i]}'></img>
            </a>
        </div>
        <p class='item-name'>{$arrOfTitles[$i]}</p>
        <p class='item-price'>{$arrOfPrices[$i]} грн</p>
        <button class='buy-button'><span class='buy-text'>Купити</span></button>
        <div class='item-description-container'>
            <p>{$arrOfDescriptions[$i]}</p>
        </div>
    </div>
    ";
    }
    echo "</div>";
}

function renderPageContainer($numberOfPages, $pageNumber)
{
    if(!$numberOfPages) return;

    $prevPageNumber = ($pageNumber - 1) === 0 ? null : $pageNumber - 1;
    $nextPageNumber = ($pageNumber + 1) > $numberOfPages ? null : $pageNumber + 1;

    echo "<div class='pages-container'>";
    echo "<i onclick='changePage({$prevPageNumber})' class='arrow fa-solid fa-chevron-left'></i>";

    if ($pageNumber < 6) {
        renderStartPageList($numberOfPages, $pageNumber);
    } else if (($pageNumber + 5) <= $numberOfPages) {
        rednerCenterOfPagesList($numberOfPages, $pageNumber);
    } else {
        renderEndOfPagesList($numberOfPages, $pageNumber);
    }

    echo "<i onclick='changePage({$nextPageNumber})' class='arrow fa-solid fa-chevron-right'></i>";
    echo "</div>";
}

function renderStartPageList($numberOfPages, $pageNumber)
{
    for ($i = 1; $i < 8; $i++) {
        if ($pageNumber == $i) echo "<span class='current-page-number'>{$i}</span>";
        else if ($i <= $numberOfPages) {
            echo "<span onclick='changePage({$i})' class='another-page-number'>{$i}</span>";
        }
    }
    if ($numberOfPages > 8) {
        echo "<span class='dots'>...</span>";
        echo "<span onclick='changePage({$numberOfPages})' class='another-page-number'>{$numberOfPages}</span>";
    }
}

function rednerCenterOfPagesList($numberOfPages, $pageNumber)
{
    echo "<span onclick='changePage(1)' class='another-page-number'>1</span>";
    echo "<span class='dots'>...</span>";
    for ($i = 2; $i > 0; $i--) {
        $prev = $pageNumber - $i;
        echo "<span onclick='changePage({$prev})' class='another-page-number'>{$prev}</span>";
    }
    echo "<span class='current-page-number'>{$pageNumber}</span>";
    for ($i = 1; $i < 3; $i++) {
        $next = $pageNumber + $i;
        echo "<span onclick='changePage({$next})' class='another-page-number'>{$next}</span>";
    }
    echo "<span class='dots'>...</span>";
    echo "<span onclick='changePage({$numberOfPages})' class='another-page-number'>{$numberOfPages}</span>";
}

function renderEndOfPagesList($numberOfPages, $pageNumber)
{
    echo "<span onclick='changePage(1)' class='another-page-number'>1</span>";
    echo "<span class='dots'>...</span>";
    for ($i = ($numberOfPages - 6); $i <= $numberOfPages; $i++) {
        if ($pageNumber == $i) echo "<span class='current-page-number'>{$i}</span>";
        else {
            echo "<span onclick='changePage({$i})' class='another-page-number'>{$i}</span>";
        }
    }
}
