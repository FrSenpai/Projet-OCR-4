/* document.addEventListener('load', (e) => {
  return tinymce.init({
        mode: "textareas",
        selector: 'textarea#postContent',
        height: 100,
        width: 550,
        menubar: false,
        plugins: ['image', 'charmap', 'uploadimage'],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link uploadimage | charmap ',
        theme: 'modern',
        relative_urls: false,
        remove_script_host: false,
        document_base_url: (!window.location.origin ? window.location.protocol + '//' + window.location.host : window.location.origin) + '/',
        setup: function(ed) {
          ed.on('init', function() {
            ed.getDoc().body.style.fontSize = '14px';
          });
          ed.on('change', function() {
            ed.save();
          });
        }
      });
  }); */


  //TODO : Possibilité d'éviter un <script> sauvage dans le html, à voir si réellement utile (possibilité de gain de performance (?) )