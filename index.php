<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Drag and Drop PHP</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div>
        <form action="upload.php" class="form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input class="name" name="name" type="text" required>
            </div>
            <div class="form-group">
                <label for="surname">Фамилия:</label>
                <input class="surname" name="surname" type="text">
            </div>
            <div class="form-group">
                <label for="mail">E-mail:</label>
                <input class="mail" name="mail" type="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input class="phone" name="phone" type="tel" pattern="[0-9]+">
            </div>
            <input class="spamControl" name="spamControl" type="hidden" value="">

            <div class="drag-and-drop" name="file" id="file" type="file">
                Перенесите файл для загрузки
            </div>
            <div class="file-list">
            </div>
            <button type="submit" class="upload-btn" onclick="uploadFiles()">Upload Files </button>
        </form>
    </div>
    <script src="app.js"></script>
</body>

</html>