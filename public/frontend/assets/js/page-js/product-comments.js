
// product details comment section

$('#comment').click(function () {
    $('#commentButton').removeClass('hide-me');
});

function secInput(id)
{
    $('#repcommentButton'+id).removeClass('hide-me');
    $('#mainComRepForm'+id).addClass('pb-3');
};

function reprepComment (id)
{
    $('#reprepcommentButton'+id).removeClass('hide-me');
};

$('#comment').keyup(function () {
    var v = $('#comment').val();
    if (v != null)
    {
        // alert('sdlfklsjdf');
        $('#comSub').removeAttr('disabled');
    }
    if (v === '')
    {
        // alert('hi');
        $('#comSub').attr('disabled', 'true');
    }
});

function secKey(id)
{
    var v = $('#repcomment'+id).val();
    if (v != null)
    {
        // alert('sdlfklsjdf');
        $('#repcomSub'+id).removeAttr('disabled');
    }
    if (v === '')
    {
        // alert('hi');
        $('#repcomSub'+id).attr('disabled', 'true');
    }
};

function reprepkey (id)
{
    var v = $('#reprepcomment'+id).val();
    if (v != null)
    {
        // alert('sdlfklsjdf');
        $('#reprepcomSub'+id).removeAttr('disabled');
    }
    if (v === '')
    {
        // alert('hi');
        $('#reprepcomSub'+id).attr('disabled', 'true');
    }
};

$('#comCancel').click(function (e) {
    e.preventDefault();
    $('#comment').val('');
});
$('.repcomCancel').click(function (e) {
    e.preventDefault();
    $('.repcomment').val('');
});
$('.reprepcomCancel').click(function (e) {
    e.preventDefault();
    $('.reprepcomment').val('');
});


function replayForm(id) {
    // $('#mainComId').click(function () {
    event.preventDefault();
    $('#mainComRepForm' + id).toggle('fade', 500);
    $('#mainComId' + id).addClass('pb-3');

};

function viewReplies (id)
{
    event.preventDefault();
    $('#subReplay'+id).toggle('fade', 500);

};

function reply(id)
{
    event.preventDefault();
    $('#reprepform'+id).toggle('fade', 500);
};
