/**
 * Call module AJAX endpoint
 *
 * @param {string} task - The task to execute (e.g., 'mod_blueprint.getData')
 * @param {object} data - Additional data to send
 * @since [EXTENSION-VERSION]
 * @returns {Promise}
 */
async function callModuleAjax(task= 'loadData', data = {}) {
    const url = 'index.php?option=com_ajax&format=json';

    // CSRF Token von Joomla holen
    const token = Joomla.getOptions('csrf.token', '');

    const params = new URLSearchParams({
        option: 'com_ajax',
        module: 'blueprint', // Module name without the 'mod_' prefix
        method: task,
        format: 'json',
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

        // Joomla AJAX Response prüfen
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

callModuleAjax('loadData', { id: 123 })
    .then(data => {
        console.log('Success:', data);
    })
    .catch(error => {
        console.error('Failed:', error);
    });
 */
