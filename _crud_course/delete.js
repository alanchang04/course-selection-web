function submitForm() {
    const courseId = document.getElementById('search').value;
    const formData = new FormData();
    formData.append('courseId', courseId);

    fetch('delete_course.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            const messageContainer = document.getElementById('message-container');
            messageContainer.innerHTML = `<div class="message">${data}</div>`;
        })
        .catch(error => {
            const messageContainer = document.getElementById('message-container');
            messageContainer.innerHTML = `<div class="message error">發生錯誤：${error}</div>`;
        });
}
