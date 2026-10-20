/**
 * Call module AJAX endpoint
 *
 * @param {string} method - The task to execute (e.g., 'getData')
 * @param {object} data - Additional data to send
 * @since [EXTENSION-VERSION]
 * @returns {Promise}
 */
async function callModuleAjax(method, data = {}) {

    const queryParams = new URLSearchParams({
        option: 'com_ajax',
        module: 'blueprint',
        method,
        format: 'json',
    })

    const url = 'index.php?' + queryParams.toString();

    // Retrieve the CSRF token from Joomla
    const token = Joomla.getOptions('csrf.token', '');

    const params = new URLSearchParams({
        [token]: 1
    });

    // Add additional data
    Object.keys(data).forEach(key => params.append(key, data[key]));

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        // Check Response
        if (result.success === false) {
            throw new Error(result.messages?.error?.[0] || 'Unknown error');
        }

        return result.data;
    } catch (error) {
        console.error('AJAX Error:', error);
        throw error;
    }
}
/*

Usage

callModuleAjax('getData', { id: 123 })
    .then(data => {
        console.log('Success:', data);
    })
    .catch(error => {
        console.error('Failed:', error);
    });
 */
