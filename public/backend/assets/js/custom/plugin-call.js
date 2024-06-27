$(function () {
    $(".select2").select2({
        minimumResultsForSearch: "",
        width: "100%",

    })
})

function resetForm(formId = null) {
    // formObject.reset();
    $('input:not([name="_token"]), input:not([name="_method"]), select').val('');
    // $("input").each(function() {
    //     if(($(this).attr('name') != '_token') || ($(this).attr('name') != '_method')){
    //         $(this).val('');
    //     }
    // });
    $('textarea').html('');
    if ($('#imagePreview'))
    {
        $('#imagePreview').attr('src', '');
    }
    $(".select2").select2({
        minimumResultsForSearch: "",
        width: "100%"
    })
    // if ($('#'+formId+ ' textarea'))
    // {
    //     $('#'+formId+' textarea').summernote();
    // }
}
