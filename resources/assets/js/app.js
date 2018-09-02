require('./bootstrap');


$('#current-month').on('change', function(e){
    e.preventDefault();
    let month = $(this).val(),
        ip = $(this).data('ip');
    window.location = '/ip/' + ip + '/' + month;
});
