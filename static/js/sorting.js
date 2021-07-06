function updateEntries(paramsString){
    $.ajax({
        type: 'GET',
        url: window.location.pathname + paramsString,
        dataType: 'html'
    }).done((data, textStatus, jqXHR) => {
        const $data = $(data);
        $data.hide();
        $('#entries').html($data);
        $data.fadeIn(200);
        window.history.pushState(null, null, window.location.pathname + '?' + paramsString.substring(11));
        setupPagination();
        addDeleteListeners();
    }).fail( (xhr, status, errorThrown) => {
        $('#errorModal div.modal-body > p').html('Sorting failed, please try again!');
        (new bootstrap.Modal(document.getElementById('errorModal'))).show();
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
    });
}

$(document).ready(function (){
    $('thead .sorting').on('click', function (e) {
        const $header = $(this);
        const sortingField = $header.attr('data-sorting-field');
        let direction = null;
        // ascending -> descending
        if  ($header.hasClass('sorting_asc')){
            $header.toggleClass('sorting_asc');
            $header.toggleClass('sorting_desc');
            direction = 'd';
        }
        // descending -> none
        else if ($header.hasClass('sorting_desc')){
            $header.toggleClass('sorting_desc');
        }
        // none -> ascending
        else if ($header.hasClass('sorting')){
            $header.siblings().filter('.sorting').removeClass('sorting_asc').removeClass('sorting_desc');
            $header.addClass('sorting_asc');
            direction = 'a';
        } 
        let paramsString = '?entries=1';
        const urlParams = new URLSearchParams(window.location.search);
        for (const key of urlParams.keys()){
            if (key !== 'entries' && key !== 'sorting')
                paramsString += '&' + key + '=' + urlParams.get(key);
        }
        if (direction)
            paramsString += '&sorting=' + direction + sortingField;

        updateEntries(paramsString);
        
    });
    $('#show').on('change', function(e){
        let paramsString = '?show=' + $(this).val();
        const urlParams = new URLSearchParams(window.location.search);
        for (const key of urlParams.keys()){
            if (key !== 'show' && key !== 'page')
                paramsString += '&' + key + '=' + urlParams.get(key);
        }
        window.location.search = paramsString;
    });
});