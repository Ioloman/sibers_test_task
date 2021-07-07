$(function(){
    // listener that is invoked when the "Save" button on user page is clicked
    $('#update').on('click', function(e){
        // get validation results
        const result = customValidate($('form'), true);
        // if no results form is submitted
        // if there are errors
        if (result){
            // prevent submittion
            e.preventDefault();
            // get form container
            const $container = $('div#content');
            // remove previous error messages
            $container.find('.alert').remove();
            // add new error messages
            for (const key in result){
                const $message = $(`<div class="alert alert-danger d-flex align-items-center col-lg-7 col-md-9 col-sm-12" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>${result[key]}</div></div>`);
                $message.hide();
                $container.prepend($message);
                $message.slideDown(400);
            }
        } else {
            $('form').append($('<input type="hidden" name="url"/>').val(window.localStorage.getItem('url')))
        }
    });
});