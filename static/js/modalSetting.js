$(function (){
    $('#createUserButton').on('click', function(){
        const $inputs = $(this).parent().parent().find('input, select');

        const data = {};

        for (const input of $inputs.serializeArray())
            if (input.value !== "")
                data[input.name] = input.value;

        const result = customValidate($inputs);
        
        const $modalBody = $(this).parent().parent().find('.modal-body');
        if (!result){
            // ajax
            $.ajax({
                type: 'POST',
                url: "/newUser.php",
                dataType: 'html',
                data: data
            }).done((data, textStatus, jqXHR) => {
                $modalBody.find('.alert').remove();
                $modalBody.find('input, select').val('');
                $modalBody.find('select[name="role"]').val(1);

                const $ul = $('ul.pagination');
                const $entries = $('#entries');
                if ($entries.children().length == parseInt($ul.attr('data-entries-show')))
                    $entries.children().last().remove();
                
                const $newEntry = $(data);
                $newEntry.hide();
                $entries.prepend($newEntry);
                $newEntry.slideDown(400);
                
                $ul.attr('data-entries-total', parseInt($ul.attr('data-entries-total')) + 1);
                
                let paramsString = '?entries=1';
                const urlParams = new URLSearchParams(window.location.search);
                for (const key of urlParams.keys()){
                    if (key !== 'entries')
                        paramsString += '&' + key + '=' + urlParams.get(key);
                }
                updateEntries(paramsString);
            }).fail((xhr, status, errorThrown) => {
                $('#errorModal div.modal-body > p').html('User cannot be added due to connection issues! Please, try again!');
                (new bootstrap.Modal(document.getElementById('errorModal'))).show();
                console.log( "Error: " + errorThrown );
                console.log( "Status: " + status );
            });

            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            
        } else {
            $modalBody.find('.alert').remove();
            for (const key in result){
                const $message = $(`<div class="alert alert-danger d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>${result[key]}</div></div>`);
                $message.hide();
                $modalBody.prepend($message);
                $message.slideDown(400);
            }
        }
    });

});