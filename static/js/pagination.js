/**
 * simple range analogue
 * 
 * @param {Number} startAt 
 * @param {Number} size 
 * @returns Array
 */
function range(startAt = 0, size) {
    return [...Array(size).keys()].map(i => i + startAt);
}

/**
 * function that take info abouts pages and
 * returns an array of ints and nulls that represent pages order
 * for example [1,2,3,null,30] or [1,null,3,4,5,6,7,null,31]
 * 
 * @param {Number} firstPage 
 * @param {Number} lastPage 
 * @param Number currentPage 
 * @returns Array
 */
function generatePagesArray(firstPage, lastPage, currentPage){
    const array = [currentPage];
    if (currentPage > firstPage) array.unshift(currentPage - 1);
    if (currentPage - 1 > firstPage) array.unshift(currentPage - 2);
    if (currentPage - 3 > firstPage) array.unshift(null);
    if (currentPage - 2 > firstPage) array.unshift(firstPage);

    if (currentPage < lastPage) array.push(currentPage + 1);
    if (currentPage + 1 < lastPage) array.push(currentPage + 2);
    if (currentPage + 3 < lastPage) array.push(null);
    if (currentPage + 2 < lastPage) array.push(lastPage);

    return array;
}

/**
 * function that updates pagination
 */
const setupPagination = () => {
    // parse all the needed info
    // container for the pagination elements
    const $ul = $('ul.pagination');
    // current url params
    const urlParams = new URLSearchParams(window.location.search);
    // current page
    const page = parseInt(urlParams.get('page') ? urlParams.get('page') : 1);
    // how many entries are displayed on the page
    const show = parseInt(urlParams.get('show') ? urlParams.get('show') : 10);
    // total amount of entries in the database
    const totalEntries = parseInt($ul.attr('data-entries-total'));
    // calculate last page
    const lastPage = parseInt(totalEntries / show) + (parseInt(totalEntries % show) ? 1 : 0);
    const firstPage = 1;


    let pages;
    switch (lastPage - firstPage) {
        // list all the pages if 6 is the last page at max
        case 0:
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
            pages = range(firstPage, lastPage);
            break;
        // if there are more than 6 pages calculate custom pattern
        default:
            pages = generatePagesArray(firstPage, lastPage, page);
            break;
    }

    // convert url params to a string to add to default url strings which is like "?page=2"
    $ul.html('');
    let paramsStringEnd = '';
    for (const key of urlParams.keys()){
        if (key !== 'page')
            paramsStringEnd += '&' + key + '=' + urlParams.get(key);
    }

    // generate and add previous button
    const $previous = $('<li class="page-item"><a class="page-link">Previous</a></li>');
    if (page == firstPage)
        $previous.addClass('disabled');
    else
        $previous.children().attr('href', window.location.pathname + '?page=' + (page - 1) + paramsStringEnd);
    $ul.append($previous);

    // generate and add pages buttons (and "..." to fill the gaps)
    for(const curPage of pages) {
        // if not null
        if (curPage){
            // create button
            const $num = $(`<li class="page-item"><a class="page-link">${curPage}</a></li>`);
            // if current highlight it
            if (curPage == page)
                $num.addClass('active');
            // add url
            $num.children().attr('href', window.location.pathname + '?page=' + curPage + paramsStringEnd);
            // add to the page
            $ul.append($num);
        // if it is null
        } else {
            // add "..." gap
            const $num = $('<li class="page-item disabled"><a class="page-link">...</a></li>');
            $ul.append($num);
        }
    }

    // generate and add "next" button
    const $next = $('<li class="page-item"><a class="page-link">Next</a></li>');
    if (page == lastPage)
        $next.addClass('disabled');
    else
        $next.children().attr('href', window.location.pathname + '?page=' + (page + 1) + paramsStringEnd);

        $ul.append($next);

    // update page data with parsed data
    $ul.attr('data-entries-show', show);
    $('total').html(totalEntries);

}

$(function () {
    // run the function
    setupPagination();
});