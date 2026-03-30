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

        // Initialisation de TinyMCE
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#contenu',
                height: 600,
                menubar: 'file edit view insert format tools table help',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount',
                    'codesample', 'directionality', 'emoticons', 'nonbreaking',
                    'pagebreak', 'quickbars', 'visualchars', 'accordion'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | link image media table | ' +
                    'forecolor backcolor emoticons | codesample pagebreak | ' +
                    'visualblocks preview fullscreen | removeformat | help',
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                quickbars_insert_toolbar: 'quickimage quicktable | hr pagebreak',
                contextmenu: 'link image table configure',
                image_advtab: true,
                image_caption: true,
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image media',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6; } img { max-width: 100%; height: auto; }',
                language: 'fr_FR'
            });
        }
    </script>
</body>
</html>
