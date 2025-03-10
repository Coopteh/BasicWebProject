<?php
$uploadDir = 'uploads/';

$maxFileSize = 2 * 1024 * 1024;

$allowedMimeTypes = ['image/jpeg', 'image/png'];

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadedFile = $_FILES['image'];

    if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
        $message = "Ошибка загрузки файла: " . getUploadErrorMessage($uploadedFile['error']);
    } else {
        if ($uploadedFile['size'] > $maxFileSize) {
            $message = "Ошибка: Размер файла превышает 2 МБ.";
        } else {
             $mimeType = mime_content_type($uploadedFile['tmp_name']);
              if (!in_array($mimeType, $allowedMimeTypes)) {
                 $message = "Ошибка: Недопустимый MIME-тип файла. Разрешены только JPEG и PNG.";
             } else {

                $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                $uniqueFileName = uniqid('img_') . '.' . $fileExtension;
                $uploadPath = $uploadDir . $uniqueFileName;

               if (move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
                   $message = "Файл успешно загружен: <a href='$uploadPath' target='_blank'>$uniqueFileName</a>";
               } else {
                    $message = "Ошибка: Не удалось переместить файл.";
                 }
             }
        }
    }
}

 function getUploadErrorMessage($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            return "Размер загруженного файла превысил значение upload_max_filesize.";
        case UPLOAD_ERR_FORM_SIZE:
            return "Размер загруженного файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.";
        case UPLOAD_ERR_PARTIAL:
            return "Файл был загружен частично.";
        case UPLOAD_ERR_NO_FILE:
            return "Файл не был загружен.";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Отсутствует временная папка.";
        case UPLOAD_ERR_CANT_WRITE:
            return "Не удалось записать файл на диск.";
         case UPLOAD_ERR_EXTENSION:
            return "Загрузка файла остановлена расширением.";
        default:
            return "Неизвестная ошибка при загрузке файла.";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загрузка изображения</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="file"] {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(100% - 22px);
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
             background-color: #4cae4c;
        }
        p {
            margin-top: 20px;
            text-align: center;
            color: #777;
        }
         a {
             color: #007bff;
              text-decoration: none;
          }
          a:hover {
             text-decoration: underline;
         }

    </style>
</head>
<body>
    <h1>Загрузите изображение</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <br><br>
        <input type="submit" value="Загрузить">
    </form>

    <?php if ($message): ?>
         <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>