<?php
$dir = 'data/';

if (!is_dir($dir)) 
    {
    mkdir($dir);
}

$currentFile = '';
$content = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
    $filename = trim($_POST['filename']);
    $fileContent = $_POST['content'];

    if (!empty($filename)) 
        {
        if (pathinfo($filename, PATHINFO_EXTENSION) !== 'txt') 
            {
            $filename .= '.txt';
        }

        if (file_put_contents($dir . $filename, $fileContent) !== false) 
            {
            $message = "Файл <b>$filename</b> успішно збережено!";
        } 
        else 
        {
            $message = "Помилка при запису файлу!";
        }
    } 
    else 
        {
        $message = "Введіть назву файлу!";
    }
}

if (isset($_GET['open'])) 
    {
    $fileToOpen = basename($_GET['open']);
    $fullPath = $dir . $fileToOpen;

    if (file_exists($fullPath)) 
        {
        $currentFile = $fileToOpen;
        $content = file_get_contents($fullPath);
    }
}

$files = glob($dir . "*.txt");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна робота 4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Завантаження файлів PHP</h1>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<div class="container">
    <div class="sidebar">
        <h3>Список файлів:</h3>
        <a href="index.php" class="btn-new">+ Створити новий</a>
        <hr>
        <ul>
            <?php foreach ($files as $file): ?>
                <?php $name = basename($file); ?>
                <li>
                    <a href="?open=<?= $name ?>"> <?= $name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="editor">
        <h3><?= $currentFile ? "Редагування: $currentFile" : "Створення нового файлу" ?></h3>
        
        <form action="index.php" method="POST">
            <label>Назва файлу:</label>
            <input type="text" name="filename" value="<?= $currentFile ?>" required>
            
            <label>Вміст:</label>
            <textarea name="content" placeholder="Введіть текст тут..."><?= htmlspecialchars($content) ?></textarea>
            
            <br><br>
            <button type="submit">Зберегти файл</button>
        </form>
    </div>
</div>

</body>
</html>