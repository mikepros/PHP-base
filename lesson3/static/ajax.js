window.addEventListener('submit' , async (event) => {
    event.preventDefault();

    let message = event.target.getElementsByTagName('span')[0];
    if (message === undefined) {
        let e = document.createElement("span");
        event.target.appendChild(e);
        message = event.target.appendChild(e);

    }

    try {
        let body = new FormData(event.target)
        let response = await fetch('main.php', {
            method: 'POST',
            body: new FormData(event.target)
        });

        let json = await response.json();
        message.className = json.state;
        message.innerHTML = json.text;
    }
    catch (e) {
        message.innerHTML = 'Помилка обробки запиту: ' + e;
    }


})