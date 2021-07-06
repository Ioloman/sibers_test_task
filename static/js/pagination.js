function range(startAt = 0, size) {
    return [...Array(size).keys()].map(i => i + startAt);
}

const setupPagination = () => {
    const $ul = $('ul.pagination');
    const urlParams = new URLSearchParams(window.location.search);
    const page = parseInt(urlParams.get('page') ? urlParams.get('page') : 1);
    const show = parseInt(urlParams.get('show') ? urlParams.get('show') : 10);
    const totalEntries = parseInt($ul.attr('data-entries-total'));
    const lastPage = parseInt(totalEntries / show) + (parseInt(totalEntries % show) ? 1 : 0);
    const firstPage = 1;

    let pages;

    switch (lastPage - firstPage) {
        case 0:
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
            pages = range(firstPage, lastPage);
            break;
        default:
            pages = [1, 2, 3, null, lastPage - 2, lastPage - 1, lastPage];
            break;
    }

    $ul.html('');
    let paramsStringEnd = '';
    for (const key of urlParams.keys()){
        if (key !== 'page')
            paramsStringEnd += '&' + key + '=' + urlParams.get(key);
    }



    const $previous = $('<li class="page-item"><a class="page-link">Previous</a></li>');
    if (page == firstPage)
        $previous.addClass('disabled');
    else
        $previous.children().attr('href', window.location.pathname + '?page=' + (page - 1) + paramsStringEnd);

    $ul.append($previous);

    for(const curPage of pages) {
        if (curPage){
            const $num = $(`<li class="page-item"><a class="page-link">${curPage}</a></li>`);
            if (curPage == page)
                $num.addClass('active');
            $num.children().attr('href', window.location.pathname + '?page=' + curPage + paramsStringEnd);
            $ul.append($num);
        } else {
            const $num = $('<li class="page-item disabled"><a class="page-link">...</a></li>');
            $ul.append($num);
        }
    }

    const $next = $('<li class="page-item"><a class="page-link">Next</a></li>');
    if (page == lastPage)
        $next.addClass('disabled');
    else
        $next.children().attr('href', window.location.pathname + '?page=' + (page + 1) + paramsStringEnd);

        $ul.append($next);

}

$(function () {
    
    setupPagination();
});