tinymce.init({
    selector: 'textarea',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});
