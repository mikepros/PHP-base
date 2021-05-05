async function request(event) {
    event.preventDefault();
    try {
        let init = {
            method: 'POST', // Set request method
            body: new FormData(event.target) // Append form values to the request body
        };

        // Sending request to the main script
        let response = await fetch('index.php', init);

        // Retrieving response as JSON
        // and converting to object with pattern: { selector: { property/method: value/argument, ... }, ... }
        let json = await response.json();

        for (const selector in json) {
            if (json.hasOwnProperty(selector)) {
                let node = document.querySelector(selector);

                if (node === undefined) console.log(`Cannot find an element ${selector}`);

                else {
                    for (const property in json[selector]) {
                        // Applying changes
                        if (typeof node[property] === 'function') node[property](...json[selector][property]);
                        else if (typeof node[property] !== "undefined") node[property] = json[selector][property];
                        else console.log(`Element "${selector}" don't have property/method "${property}"`);
                    }
                }
            }
        }
    } catch (e) {
        let message = 'Помилка обробки запиту: ' + e;
        console.error(message);
        alert(message);
    }
}

window.addEventListener('submit', request)