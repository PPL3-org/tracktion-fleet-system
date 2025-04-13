const truckId = window.truckId;
const currentUrl = window.location.href;

/**
 * Shows the loading overlay and hides the main content.
 */
function showLoading() {
    document.getElementById('loading-overlay').classList.remove('hidden');
    document.getElementById('main-content').classList.add('hidden');
}

/**
 * Hides the loading overlay and shows the main content.
 */
function hideLoading() {
    document.getElementById('loading-overlay').classList.add('hidden');
    document.getElementById('main-content').classList.remove('hidden');
}

function showErrorAlert() {
    const alert = document.getElementById('error-alert');
    
    alert.classList.remove('hidden');
    document.getElementById('loading-overlay').classList.add('hidden');
    document.getElementById('main-content').classList.remove('hidden');

    setTimeout(() => {
        alert.classList.remove('-translate-y-full');
        alert.classList.add('translate-y-4');
    }, 10);
    
    setTimeout(() => {
        alert.classList.remove('translate-y-4');
        alert.classList.add('-translate-y-full');
        setTimeout(() => alert.classList.add('hidden'), 500); // wait for transition to complete
    }, 5000);
}

/**
 * Starts tracking by sending the current geolocation to the server.
 */
function startTracking() {
    showLoading();

    navigator.geolocation.getCurrentPosition(
        async (position) => {
            try {
                const { latitude, longitude } = position.coords;

                const res = await fetch('/api/location/start-tracking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ latitude, longitude, truck_id: truckId })
                });

                const data = await res.json();

                if (data) {
                    window.location.href = currentUrl + '/on-going';
                }
            } catch (error) {
                showErrorAlert();
            }
        },
        (error) => {
            showErrorAlert();
        }
    );
}

/**
 * Finishes tracking by sending the current geolocation to the server,
 * then shows a finish animation for 5 seconds before reloading the page.
 */
function finishTracking() {
    showLoading();

    navigator.geolocation.getCurrentPosition(
        async (position) => {
            try {
                const { latitude, longitude } = position.coords;

                const res = await fetch('/api/location/finish-tracking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ latitude, longitude, truck_id: truckId })
                });

                const data = await res.json();

                if (data) {
                    // Hide the loading overlay and show the finish animation.
                    document.getElementById('loading-overlay').classList.add('hidden');
                    document.getElementById('finish-shipping-animation').classList.remove('hidden');

                    // After 5 seconds, hide the animation, show the main content, and force a reload.
                    setTimeout(() => {
                        window.location.href = currentUrl.replace('/on-going', '');
                    }, 5000);
                } 
            } catch (error) {
                showErrorAlert();
            }
        },
        (error) => {
            showErrorAlert();
        }
    );
}