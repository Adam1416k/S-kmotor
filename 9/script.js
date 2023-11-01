//håller koll på när dokumentet laddats
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    //lyssnare för submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const directoryName = form.directory.value;
        fetch('search.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `directory=${encodeURIComponent(directoryName)}`,
        })
        .then(response => response.text())
        .then(data => {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = `<hr>${data}`;
        });
    });
});