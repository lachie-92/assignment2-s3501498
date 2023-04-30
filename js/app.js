// Get the form and the query button
const queryForm = document.getElementById('query-form');
const queryBtn = document.getElementById('query-btn');

// Get the result area
const resultsArea = document.getElementById('grid-container');

// Get the query input fields
const titleInput = document.getElementById("title");
const artistInput = document.getElementById("artist");
const yearInput = document.getElementById("year");

// Get the subscription area and the subscription button
const subscriptionArea = document.getElementById('subscription-area');
const subscribeBtns = document.getElementsByClassName('subscribe-btn');

// Add an event listener to the query button
queryBtn.addEventListener('click', () => {
    // Get the query inputs
    let title = "";
    let artist = "";
    let year = "";

    if (titleInput.value) {
        title = titleInput.value;
    }

    if (artistInput.value) {
        artist = artistInput.value;
    }

    if (yearInput.value) {
        year = yearInput.value;
    }

    // Build the query string based on the inputs
    let queryString = '';
    queryString += `Title=${title}&`;
    queryString += `Year=${year}&`;
    queryString += `Artist=${artist}&`;

    // Send the query request to the server
    fetch(`/query?${queryString}`)
        .then(response => response.json())
        .then(data => {
            // Clear the subscription area
            resultsArea.innerHTML = '';

            if (data.length === 0) {
                // Show a message if no results are found
                resultsArea.innerHTML = '<p>No result is retrieved. Please query again.</p>';
            } else {
                // Loop through the results and create the HTML elements
                data.forEach(item => {
                    const musicInfo = `
                        <div class="music-info">
                            <p class="music-title">${item.title}</p>
                            <p class="music-year">${item.year}</p>
                            <p class="music-artist">${item.artist}</p>
                            <button class="subscribe-btn" data-id="${item.id}">Subscribe</button>
                        </div>
                    `;
                    const artistImage = `<img class="music-image" src="${item.img_url}" alt="${item.artist}">`;
                    const resultDiv = `
                        <div class="grid-item">
                            <div class="music-container">
                                ${artistImage}
                            </div>
                            ${musicInfo}
                        </div>
                    `;
                
                    // Add the result to the subscription area
                    resultsArea.insertAdjacentHTML('beforeend', resultDiv);
                });

                // Add event listeners to the subscription buttons
                Array.from(subscribeBtns).forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;

                        // Send a subscription request to the server
                        fetch(`/subscribe?id=${id}`)
                            .then(response => response.json())
                            .then(data => {
                                // Show a message indicating success or failure
                                if (data.success) {
                                    alert('Subscribed successfully!');
                                } else {
                                    alert('Failed to subscribe. Please try again.');
                                }
                            });
                    });
                });
            }
        });
});

// // Loop through the subscription results and create the HTML table rows
// data.forEach(item => {
//     const row = document.createElement('tr');
    
//     const titleCell = document.createElement('td');
//     titleCell.textContent = item.Title;
    
//     const artistCell = document.createElement('td');
//     artistCell.textContent = item.Artist;
    
//     const yearCell = document.createElement('td');
//     yearCell.textContent = item.Year;
    
//     const unsubscribeCell = document.createElement('td');
//     const unsubscribeBtn = document.createElement('button');
//     unsubscribeBtn.classList.add('unsubscribe-btn');
//     unsubscribeBtn.dataset.title = item.Title;
//     unsubscribeBtn.dataset.artist = item.Artist;
//     unsubscribeBtn.dataset.year = item.Year;
//     unsubscribeBtn.dataset.image = item.ImageURL;
//     unsubscribeBtn.textContent = 'Unsubscribe';
//     unsubscribeCell.appendChild(unsubscribeBtn);
    
//     row.appendChild(titleCell);
//     row.appendChild(artistCell);
//     row.appendChild(yearCell);
//     row.appendChild(unsubscribeCell);
    
//     subscriptionTable.appendChild(row);
// });

// // Add event listeners to the unsubscribe buttons
// Array.from(unsubscribeBtns).forEach(btn => {
//     btn.addEventListener('click', () => {
//         const title = btn.dataset.title;
//         const artist = btn.dataset.artist;
//         const year = btn.dataset.year;
//         const imageURL = btn.dataset.image;

//         // Send an unsubscribe request to the server
//         fetch(`/unsubscribe?Title=${title}&Artist=${artist}&Year=${year}&ImageURL=${imageURL}`)
//             .then(response => response.json())
//             .then(data => {
//                 // Show a message indicating success or failure
//                 if (data.success) {
//                     alert('Unsubscribed successfully!');
//                     // Reload the page to update the subscription list
//                     location.reload();
//                 } else {
//                     alert('Failed to unsubscribe. Please try again.');
//                 }
//             });
//     });
// });

