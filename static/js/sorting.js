/**
 * function that updates entries on the main page based on given parameters
 * 
 * @param {String} paramsString 
 */
function updateEntries(paramsString){
    // ajax request with passed params string
    $.ajax({
        type: 'GET',
        url: window.location.pathname + paramsString,
        dataType: 'html'
    }).done((data, textStatus, jqXHR) => {
        // on success update page content with received data
        const $data = $(data);
        $data.hide();
        $('#entries').html($data);
        $data.fadeIn(200);
        // update url to correspond to actual content
        window.history.pushState(null, null, window.location.pathname + '?' + paramsString.substring(11));
        // update pagination
        setupPagination();
        // add delete listener to the buttons
        addDeleteListeners();
    }).fail( (xhr, status, errorThrown) => {
        // on failure show error message
        $('#errorModal div.modal-body > p').html('Sorting failed, please try again!');
        (new bootstrap.Modal(document.getElementById('errorModal'))).show();
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
    });
}

$(document).ready(function (){
    // event listeners for sorting visualization and dynamic content update
    // listeners are added to a specific table headers that allow sorting
    $('thead .sorting').on('click', function (e) {
        // get clicked header
        const $header = $(this);
        // get the name of field the header represents
        const sortingField = $header.attr('data-sorting-field');

        // variable to store sorting order
        let direction = null;

        // the following only manages visualization
        // ascending -> descending
        // if header was in ascending order change it to descending order
        if  ($header.hasClass('sorting_asc')){
            $header.toggleClass('sorting_asc');
            $header.toggleClass('sorting_desc');
            direction = 'd';
        }
        // descending -> none
        // if header was in descending order change it to no sorting on that field
        else if ($header.hasClass('sorting_desc')){
            $header.toggleClass('sorting_desc');
        }
        // none -> ascending
        // if header was't sorted by that field change it to ascending
        // and clear all other headers
        else if ($header.hasClass('sorting')){
            $header.siblings().filter('.sorting').removeClass('sorting_asc').removeClass('sorting_desc');
            $header.addClass('sorting_asc');
            direction = 'a';
        } 

        // prepare params to make an ajax request
        let paramsString = '?entries=1';
        const urlParams = new URLSearchParams(window.location.search);
        for (const key of urlParams.keys()){
            if (key !== 'entries' && key !== 'sorting')
                paramsString += '&' + key + '=' + urlParams.get(key);
        }
        if (direction)
            paramsString += '&sorting=' + direction + sortingField;

        // update page content
        updateEntries(paramsString);
    });


    // another event listener that is invoked when th amount of entries to be shown is changed
    $('#show').on('change', function(e){
        // prepare url params
        let paramsString = '?show=' + $(this).val();
        const urlParams = new URLSearchParams(window.location.search);
        for (const key of urlParams.keys()){
            if (key !== 'show' && key !== 'page')
                paramsString += '&' + key + '=' + urlParams.get(key);
        }
        // update the page
        window.location.search = paramsString;
    });
});