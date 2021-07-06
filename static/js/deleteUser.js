function addDeleteListeners(){
    $('button[data-delete-entry="true"]').on('click', function() {
        $button = $(this);
        id = $button.parent().parent().attr('id');

        $.ajax({
            type: 'POST',
            url: "/deleteUser.php",
            dataType: 'text',
            data: {id: id}
        }).done((data, textStatus, jqXHR) => {
            $button.parent().parent().fadeOut(200);
            $button.parent().parent().remove();
            
            const $ul = $('ul.pagination');
            $ul.attr('data-entries-total', parseInt($ul.attr('data-entries-total')) - 1);
            
            let paramsString = '?entries=1';
            const urlParams = new URLSearchParams(window.location.search);
            for (const key of urlParams.keys()){
                if (key !== 'entries')
                    paramsString += '&' + key + '=' + urlParams.get(key);
            }
            updateEntries(paramsString);
        }).fail((xhr, status, errorThrown) => {
            $('#errorModal div.modal-body > p').html('User cannot be deleted due to connection issues! Please, try again!');
            (new bootstrap.Modal(document.getElementById('errorModal'))).show();
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
        });
    })
}

$(function() {
    addDeleteListeners();
});