document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();
    uploadFile();
});

function uploadFile() {
    var fileInput = document.getElementById('fileToUpload');
    var file = fileInput.files[0];

    var formData = new FormData();
    formData.append('file', file);

    var filename = file.name;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/subjects', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            var resultDiv = document.getElementById('result');
            resultDiv.innerHTML = JSON.stringify(data);
        } else {
            console.error('Error uploading file');
        }
    };

    xhr.send(formData);
}