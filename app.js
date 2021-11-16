let filesForUpload = []; // Хранилище файлов

// Назначение переменных
let dragAndDrop = document.querySelector('.drag-and-drop'),
  imagesList = document.querySelector('.file-list'),
  uploadBtn = document.querySelector('.upload-btn'),
  spamControl = document.querySelector('.spamControl'),
  form = document.querySelector('.form');

// Действия при переносе файла в поле хранилища
dragAndDrop.addEventListener('dragenter', (e) => {
  e.preventDefault();
  dragAndDrop.classList.add('active');
});
dragAndDrop.addEventListener('dragleave', (e) => {
  e.preventDefault();
  dragAndDrop.classList.remove('active');
});
dragAndDrop.addEventListener('dragover', (e) => {
  e.preventDefault();
});
dragAndDrop.addEventListener('drop', (e) => {
  e.preventDefault();
  const files = e.dataTransfer.files;
  for (let key in files) {
    if (!files[key].size) {
      continue;
    }
    // Добавление файлов в хранилище
    filesForUpload.push(files[key]);
    // Отрисовка иконок новых файлов
    imagesList.innerHTML += `<img src="image.png" class="file-list-picture" alt="">`;
  }
});

// Сбор файлов при нажатии Upload Files
const uploadFiles = () => {
  spamControl.value = 'secret'; // Защита от спама через невидимый инпут

  let formData = new FormData();
  filesForUpload.forEach((image, key) => {
    formData.append(key, image);
  });
  // Проверка на вложенность файлов
  if (filesForUpload.length < 1) {
    alert('Прикрепите файл');
  }
  // Передача данных на сервер
  fetch('upload.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.status) {
        alert('Файлы успешно загружены');
      }
    });
};
