/**
 * function to add listeners to delete buttons on the main page
 */

function addDeleteListeners(){
    $('button[data-delete-entry="true"]').on('click', function() {
        $button = $(this);
        id = $button.parent().parent().attr('id');

        // make ajax request to the server
        $.ajax({
            type: 'POST',
            url: "/deleteUser.php",
            dataType: 'text',
            data: {id: id}
        }).done((data, textStatus, jqXHR) => {
            // on success remove deleted entry
            $button.parent().parent().fadeOut(200);
            $button.parent().parent().remove();
            
            // update amount of entries in client for pagination
            const $ul = $('ul.pagination');
            $ul.attr('data-entries-total', parseInt($ul.attr('data-entries-total')) - 1);
            
            // prepare url to request entries list from server
            let paramsString = '?entries=1';
            const urlParams = new URLSearchParams(window.location.search);
            for (const key of urlParams.keys()){
                if (key !== 'entries')
                paramsString += '&' + key + '=' + urlParams.get(key);
            }
            // update list of entries to put the entry in the right position
            updateEntries(paramsString);
        }).fail((xhr, status, errorThrown) => {
            // on failure show error message
            $('#errorModal div.modal-body > p').html('User cannot be deleted due to connection issues! Please, try again!');
            (new bootstrap.Modal(document.getElementById('errorModal'))).show();
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
        });
    })

    // listeners to remember url when going to update page
    // sorry for leaving it in this file
    $('a[data-update-link="true"]').on('click', function (){
        window.localStorage.setItem('url', window.location.search);
    });
}

$(function() {
    addDeleteListeners();
});