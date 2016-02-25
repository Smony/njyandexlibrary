<?php

// Подключаем autoload.php из phar-архива
require_once 'vendor/autoload.php';
// Подключаем autoload.php из phar-архива
//require_once 'phar://yandex-php-library_master.phar/vendor/autoload.php';

define('ACCESS_TOKEN', 'bbbef0b0944e4ce79219ac5884cbbebc');

use Yandex\Disk\DiskClient;
//
$diskClient = new DiskClient(ACCESS_TOKEN);
$diskClient->setServiceScheme(DiskClient::HTTPS_SCHEME);

//Получаем свободное и занятое место
$diskSpace = $diskClient->diskSpaceInfo();?>
Всего места: <?=$diskSpace['availableBytes']?> байт.
<br />
Использовано: <?=$diskSpace['usedBytes']?> байт.
<br />
Свободно: <?=round(($diskSpace['availableBytes'] - $diskSpace['usedBytes']) / 1024 / 1024 / 1024, 2)?> ГБ
из <?=round($diskSpace['availableBytes'] / 1024 / 1024 / 1024, 2)?> ГБ.

    <hr>

<?php
$login = $diskClient->getLogin();
?>
    Привет, <?=$login?>

    <hr>
<?php
// Получаем список файлов из директории
$dirContent = $diskClient->directoryContents('/');
$files = $diskClient->directoryContents('/');

foreach ($dirContent as $dirItem) {
if ($dirItem['resourceType'] === 'dir') {
    echo 'Директория "' . $dirItem['displayName'] . '" была создана ' . date(
    'Y-m-d в H:i:s',
    strtotime($dirItem['creationDate'])
    ) . '<br />';
    } else {
    echo 'Файл "' . $dirItem['displayName'] . '" с размером в ' . $dirItem['contentLength'] . ' байт был создан ' . date(
    'Y-m-d в H:i:s',
    strtotime($dirItem['creationDate'])
    ) . '<br />';
    }
}?>

    <hr>
<?php

foreach($files as $file){
    #print_r($file);
    if($file['resourceType'] == 'file'){
        echo $file['displayName'].'<br />';
    }
}?>
    <hr>
<?php

//Публикуем
$path = '/vasya';
$url = $diskClient->startPublishing($path);?>
    <a href="<?= $url ?>">Ссылка на "<?= $path ?>"</a>
<?php
$diskClient->startPublishing($path);
/*
//Делаем не публичной
$diskClient->stopPublishing($path);
#$diskClient->startPublishing($path);
//Проверяем, публичная ли
if ($diskClient->checkPublishing($path)) {
    echo 'Директория опубликована';
} else {
    echo 'Директория не опубликована';
}

*/

?>

    <hr />
<?php
#DELETE FILE
/*
    $target = '/vasya/1.jpg';

    if ($diskClient->delete($target)) {
        echo 'Файл "' . $target . '" был удален';
    }
*/


/*
$path = '/vasya';
//Устанавливаем свойство у каталога
$result = $diskClient->setProperty($path, 'myprop', 'myvalue');
if ($result) {
    //Получение свойства у каталога
    $value = $diskClient->getProperty($path, 'myprop');
}

*/

/*
$path = 'vasya';

$dirContent = $diskClient->createDirectory($path);
if ($dirContent) {
    echo 'Создана новая директория "' . $path . '"!';
}

*/
/*
    $fileName = 'кровать.jpg';
    $newName = $path.'кровать.jpg';

    $diskClient->uploadFile(
        '/new folder/',
        array(
            'path' => $fileName,
            'size' => filesize($fileName),
            'name' => $newName
        )
    );

*/


/*
    $target = '/vasya/1.jpg';
    //Сохранение превьюшки
    $size = 'XXXS';
    $file = $diskClient->getImagePreview($target, $size);
    file_put_contents('1.jpg', $file['body']);

    //Вывод превьюшки
    $size = '700x1000';
    $file = $diskClient->getImagePreview($target, $size);

    header('Content-Description: File Transfer');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Date: ' . $file['headers']['Date']);
    header('Content-Type: image/jpeg');
    header('Content-Length: ' . $file['headers']['Content-Length']);
    header('Accept-Ranges: ' . $file['headers']['Accept-Ranges']);
    echo $file['body'];
*/