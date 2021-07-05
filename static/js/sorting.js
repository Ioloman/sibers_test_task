$(function (){
    $('thead .sorting').on('click', function (e) {
        const $header = $(this);
        if  ($header.hasClass('sorting_asc')){
            $header.toggleClass('sorting_asc');
            $header.toggleClass('sorting_desc');
        }
        else if ($header.hasClass('sorting_desc')){
            $header.toggleClass('sorting_desc');
        }
        else if ($header.hasClass('sorting')){
            $header.siblings().filter('.sorting').removeClass('sorting_asc').removeClass('sorting_desc');
            $header.addClass('sorting_asc');
        } 
    });
});