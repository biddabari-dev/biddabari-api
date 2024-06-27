// home page js scripts start

// news tinker plugin start
jQuery(document).ready(function ($) {
    $('.my-news-ticker').AcmeTicker({
        type:'marquee',/*horizontal/horizontal/Marquee/type*/
        direction: 'left',/*up/down/left/right*/
        speed:0.05,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
        controls: {
            prev: $('.acme-news-ticker-prev'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
            toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
            next: $('.acme-news-ticker-next')/*Can be used for horizontal/horizontal/marquee/typewriter*/
        }
    });
})
// news tinker plugin end
// multi count down start
$(document).ready(function () {
    var date = new Date(); // Now
    date.setDate(date.getDate() + 30); // Set now + 30 days as the new date
    const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
    const mo = new Intl.DateTimeFormat('en', { month: 'numeric' }).format(date);
    const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);
    const dateText = ye + '/' + mo + '/' + da;
});
// multi count down end

// home page js scripts ends



// courses page js scripts start
// filter functions
var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function() {
        var number = $(this).find('.number').text();
        return parseInt( number, 10 ) > 50;
    },
    // show if name ends with -ium
    ium: function() {
        var name = $(this).find('.name').text();
        return name.match( /ium$/ );
    }
};

// bind filter button click
$('#filters').on( 'click', 'button', function() {
    var filterValue = $( this ).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[ filterValue ] || filterValue;
    $grid.isotope({ filter: filterValue });
});

// bind sort button click
$('#sorts').on( 'click', 'button', function() {
    var sortByValue = $(this).attr('data-sort-by');
    $grid.isotope({ sortBy: sortByValue });
});

// change is-checked class on buttons
$('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $( this ).addClass('is-checked');
    });
});
// courses page js scripts end
