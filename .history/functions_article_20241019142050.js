document.getElementById('submit_comment').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('comment-form'));

    fetch('send_comment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('response-message').innerHTML = data;
        document.getElementById('comment-form').reset();
    })
    .catch(error => {
        console.error('Erreur lors de l'envoi du formulaire :', error);
    });
