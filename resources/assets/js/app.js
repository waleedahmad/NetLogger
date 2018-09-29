require('./bootstrap');


$('#current-month').on('change', function(e){
    e.preventDefault();
    let month = $(this).val(),
        id = $(this).data('id');
    window.location = '/ip/' + id + '/' + month;
});
