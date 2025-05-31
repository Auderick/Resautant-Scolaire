// Logger utility
const Logger = {
    async log(message, type = 'info') {
        try {
            const response = await fetch('/api/log.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message,
                    type,
                    timestamp: new Date().toISOString()
                })
            });
            return await response.json();
        } catch (error) {
            console.error('Logging failed:', error);
        }
    }
};
