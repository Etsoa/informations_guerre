    </main>

    <footer class="admin-footer">
        <p>&copy; <?= date('Y') ?> - Informations Guerre - BackOffice</p>
    </footer>

    <script>
        // AJAX Helper function
        function ajax(method, url, data = null, callback = null) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            if (method === 'POST' && data) {
                if (data instanceof FormData) {
                    xhr.send(data);
                } else {
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    const params = new URLSearchParams(data).toString();
                    xhr.send(params);
                }
            } else {
                xhr.send();
            }

            xhr.onload = function() {
                if (callback) callback(xhr.responseText, xhr.status);
            };
        }

        // Message d'alerte global
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.textContent = message;
            alertDiv.style.padding = '10px';
            alertDiv.style.margin = '10px 0';
            alertDiv.style.border = '1px solid';
            
            if (type === 'success') {
                alertDiv.style.borderColor = '#28a745';
                alertDiv.style.backgroundColor = '#d4edda';
                alertDiv.style.color = '#155724';
            } else if (type === 'error') {
                alertDiv.style.borderColor = '#dc3545';
                alertDiv.style.backgroundColor = '#f8d7da';
                alertDiv.style.color = '#721c24';
            } else {
                alertDiv.style.borderColor = '#17a2b8';
                alertDiv.style.backgroundColor = '#d1ecf1';
                alertDiv.style.color = '#0c5460';
            }
            
            const main = document.querySelector('main');
            main.insertBefore(alertDiv, main.firstChild);
            
            setTimeout(() => alertDiv.remove(), 5000);
        }
    </script>
</body>
</html>
