    $(document).ready(function (){
        $(document.body).on('submit', '.js-confirm', function(){
            var $el = $(this)
            var text = $el.data('confirm') ? $el.data('confirm') : 'Anda Yakin Ingin ? Data Tidak Bisa Dikembalikan'
            var c = confirm(text)
            return c;
        })

        $('.js-selectize').selectize({
            sortField: 'text'
        });
    });