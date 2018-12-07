<?php

/* @var $arDirAll[]  */
/* @var $arDirInfo[]  */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii2mod\tree\Tree;

$this->title = 'My Dir';

?>

<div class="container">
<?php
    echo '<h3><a href=', Url::to(['dir/index']), '>Корневой каталог</a></h3>';
    echo '<h2>Выбранный ресурс: ', $arDirInfo[0], "</h2>", PHP_EOL;
?>

<?php

if(isset($arDirInfo[1])) {
    echo '<div>Тип: ', $arDirInfo[1]==1 ? 'Каталог' : 'Файл';
    echo '<br>ID Владельца: ', $arDirInfo[2]["uid"];
    echo '<br>Размер: ', $arDirInfo[2]["size"], " байт";
    echo '<br>Изменен: ', date("d.m.Y  H:i:s.", $arDirInfo[2]["ctime"]), "</div>", PHP_EOL;
}

if ($arDirAll) {
    echo '<a href="',
        Url::to(['dir/export', 'path' => $arDirInfo[0]]),
        "\" target='_blank'>Export to XML</a><br>", PHP_EOL;
    echo '<h4>Содержит: </h4>';

    echo Tree::widget([
        'items' => $arDirAll
    ]);
}

echo 'Время выполнения скрипта: '.(microtime(true) - Yii::$app->params['MyStartTime']).' сек.';

?>

</div>
