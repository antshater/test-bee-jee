'use strict';
var mode = 'edit';

var fillPreview = function () {
    ['user_name', 'email', 'description'].forEach(function (attribute) {
        var value = document.querySelector(`[name="task[${attribute}]"]`).value;
        document.querySelector(`.preview.${attribute}`).textContent = value;
    });
    var previewFile = document.querySelector(`.preview.file`);
    previewFile.textContent = '';
    var fileInput = document.querySelector('[name="file"]');
    if (fileInput.files[0]) {
        var fReader = new FileReader();
        fReader.readAsDataURL(fileInput.files[0]);
        fReader.onloadend = function (event) {
            var img = new Image();
            img.src = event.target.result;
            previewFile.appendChild(img);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var previewBtn = document.getElementById('preview-btn');
    if (! previewBtn) {
        return;
    }

    previewBtn.addEventListener('click', function () {
        mode = mode === 'preview' ? 'edit' : 'preview';
        var classList = document.getElementById('edit-form').classList;
        if (mode === 'preview') {
            classList.remove('edit-mode');
            classList.add('preview-mode');
            fillPreview();
            this.textContent = 'Редактировать';
        } else {
            classList.add('edit-mode');
            classList.remove('preview-mode');
            this.textContent = 'Предварительный просмотр';
        }
    });
});

