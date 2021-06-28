let editor_template
   DecoupledEditor
      .create(document.querySelector('#editor'), {
         fontSize: {
            options: [
               9, 11, 'default',13,14,17,19,21
            ],
            supportAllValues: true
         },
      })
      .then(editor => {
         editor_template = editor;
            const toolbarContainer = document.querySelector('#toolbar-container');

            toolbarContainer.appendChild(editor.ui.view.toolbar.element );
      })
      .catch(error => {
            console.error(error);
      });

      document.querySelector('#submit').addEventListener('click', () => {
         const nama = document.getElementById('nama-template')
         const template = editor_template.getData();
         // Send a POST request
         const data = {
            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
            nama_template: nama.value,
            template,
         }
         console.log(data)
         axios.post('<?= base_url('admin/template/insert') ?>', data)
         .then(function (response) {
            console.log(response.data);
         })
         .catch(function (error) {
            console.log(error);
         });
      });