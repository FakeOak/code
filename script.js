// Function to fetch data from the backend
async function fetchData() {
    try {
        const response = await fetch('backend.php?endpoint=fetchData');
        const data = await response.json();

        if (response.ok) {
            console.log(data); // Display data in the console
            // Example: Render data to the DOM
            const container = document.getElementById('data-container');
            container.innerHTML = data.map(item => `<p>${item.name} - ${item.email}</p>`).join('');
        } else {
            console.error(data.message);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

// Call fetchData on page load
document.addEventListener('DOMContentLoaded', fetchData);

document.addEventListener('DOMContentLoaded', () => {
    fetch('backend.php')
        .then(response => response.json())
        .then(data => {
            const productContainer = document.querySelector('.cake-grid');
            productContainer.innerHTML = ''; // Clear existing content

            data.forEach(product => {
                const productHTML = `
                    <div class="cake-item" data-name="${product.name}" data-price="${product.price}">
                        <img src="${product.image}" alt="${product.name}">
                        <div class="cake-details">
                            <p class="cake-price">${product.name} ${product.price} บ.</p>
                            <button class="order-btn" onclick="addToCart('${product.name}', ${product.price}, '${product.image}')">ใส่ตะกร้า</button>
                        </div>
                    </div>
                `;
                productContainer.innerHTML += productHTML;
            });
        })
        .catch(error => console.error('Error fetching products:', error));
});
