/**
 * adding listener to user creation button in the modal on the main page
 */
$(function (){
    $('#createUserButton').on('click', function(){
        // find all the input fields
        const $inputs = $(this).parent().parent().find('input, select');

        // form an object suitable for validation
        const data = {};
        for (const input of $inputs.serializeArray())
            if (input.value !== "")
                data[input.name] = input.value;

        // use a function from helpers.js
        const result = customValidate($inputs);
        
        // find a container to add the errors
        const $modalBody = $(this).parent().parent().find('.modal-body');
        // if no errors occured
        if (!result){
            // send ajax request
            $.ajax({
                type: 'POST',
                url: "/newUser.php",
                dataType: 'html',
                data: data
            }).done((data, textStatus, jqXHR) => {
                // on success remove previous error messages
                $modalBody.find('.alert').remove();
                // clear input fields
                $modalBody.find('input, select').val('');
                $modalBody.find('select[name="role"]').val(1);

                // remove last entry if the page is full
                const $ul = $('ul.pagination');
                const $entries = $('#entries');
                if ($entries.children().length == parseInt($ul.attr('data-entries-show')))
                    $entries.children().last().remove();
                
                // form and add a new entry
                const $newEntry = $(data);
                $newEntry.hide();
                $entries.prepend($newEntry);
                $newEntry.slideDown(400);
                
                // update data for pagination
                $ul.attr('data-entries-total', parseInt($ul.attr('data-entries-total')) + 1);
                
                // make url to request entries list to update current list
                let paramsString = '?entries=1';
                const urlParams = new URLSearchParams(window.location.search);
                for (const key of urlParams.keys()){
                    if (key !== 'entries')
                        paramsString += '&' + key + '=' + urlParams.get(key);
                }
                // update list of entries
                updateEntries(paramsString);
            }).fail((xhr, status, errorThrown) => {
                // on failure show error message
                $('#errorModal div.modal-body > p').html('User cannot be added due to connection issues! Please, try again!');
                (new bootstrap.Modal(document.getElementById('errorModal'))).show();
                console.log( "Error: " + errorThrown );
                console.log( "Status: " + status );
            });

            // hide modal with inputs
            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            
        } else {
            // if validation errors occured
            // remove previous error messages
            $modalBody.find('.alert').remove();
            // add new error messages
            for (const key in result){
                const $message = $(`<div class="alert alert-danger d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>${result[key]}</div></div>`);
                $message.hide();
                $modalBody.prepend($message);
                $message.slideDown(400);
            }
        }
    });

});