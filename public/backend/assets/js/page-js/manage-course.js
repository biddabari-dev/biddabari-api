$(function () {
    $(".summernote").summernote({
        height:70,
        inheritPlaceholder: true
    });
    // CKEDITOR.replace( 'description' );

    const date = new Date();

    $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    $("#admissionLastDate").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
    $('.select2').select2();
    $('input[data-dtp="dtp_Nufud"]').val(currentDateTime);
})
$(document).on('click', '.dtp-btn-cancel', function () {
    alert('sdfsdf');
})

// edit course category
$(document).on('click', '.edit-btn', function () {
    event.preventDefault();
    var courseId = $(this).attr('data-course-id');
    $.ajax({
        url: "/courses/"+courseId+"/edit",
        method: "GET",
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);

            $('#modalForm').empty().append(data);
            // $("#summernote").summernote({height:70, inheritPlaceholder: true});
            // $("#summernote1").summernote({height:70, inheritPlaceholder: true});
            // CKEDITOR.replace( 'description' );

            $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#admissionLastDate").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

            $('.select2').select2({
                placeholder: $(this).attr('data-placeholder'),
            });
            $('.submit-btn').addClass('update-btn').removeClass('submit-btn');

            $('#coursesModal').modal('show');
        }
    })
})
$(document).on('click', '.show-btn', function () {
    event.preventDefault();
    var courseId = $(this).attr('data-course-id');
    $.ajax({
        url: base_url+"courses/"+courseId,
        method: "GET",
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);

            $('#modalForm').empty().append(data);
            $("#summernote").summernote({height:70, inheritPlaceholder: true});
            // $("#summernote1").summernote({height:70, inheritPlaceholder: true});
            // CKEDITOR.replace( 'description' );

            $("#dateTime").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime1").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime2").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#dateTime3").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});
            $("#admissionLastDate").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});

            $('.select2').select2({
                placeholder: $(this).attr('data-placeholder'),
            });
            // $('.submit-btn').addClass('update-btn').removeClass('submit-btn');

            $('#coursesModal').modal('show');
        }
    })
})

// update course category
$(document).on('click', '.update-btn', function () {
    event.preventDefault();

    var discountAmount = Number($('input[name="discount_amount"]').val());
    if(discountAmount != '')
    {
        var price = Number($('input[name="price"]').val());
        if (discountAmount > price)
        {
            $('#discountErrorMsg').text('Discount amount should be lower then Price.');
            return false;
        }
    }

    var form = $('#coursesForm')[0];
    var formData = new FormData(form);
    var des = CKEDITOR.instances['description'].getData();
    formData.append('description',des);
    console.log(formData);
    $.ajax({
        url: $('#coursesForm').attr('action'),
        method: "POST",
        data: formData,
        // dataType: "JSON",
        // async: false,
        // cache: false,
        contentType: false,
        processData: false,
        // enctype: 'multipart/form-data',
        beforeSend: function () {

            $('.update-btn').attr('disabled', 'disabled');
        },
        success: function (message) {
            // console.log(message);
            toastr.success(message);
            $('.update-btn').addClass('submit-btn').removeClass('update-btn');
            $('#courseCategoryForm').attr('action', '');
            $('#courseCategoryModal').modal('hide');
            window.location.reload();
        },
        error: function (errors) {
            if (errors.responseJSON)
            {

                var allErrors = errors.responseJSON.errors;
                for (key in allErrors)
                {
                    $('#'+key).empty().append(allErrors[key]);
                    console.log(key);
                }
                $('.update-btn').attr('disabled', false);
            }
        }
    })
})

// store course
$(document).on('click', '.submit-btn', function () {
    event.preventDefault();
    var discountAmount = Number($('input[name="discount_amount"]').val());
    if(discountAmount != '')
    {
        var price = Number($('input[name="price"]').val());
        if (discountAmount > price)
        {
            $('#discountErrorMsg').text('Discount amount should be lower then Price.');
            return false;
        }
    }

    var form = $('#coursesForm')[0];
    var formData = new FormData(form);
    var des = CKEDITOR.instances['ck'].getData();
    formData.append('description',des);
    $.ajax({
        url: base_url+"courses",
        method: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        beforeSend: function () {

            $('.submit-btn').attr('disabled', 'disabled');
        },
        success: function (data) {
            // console.log(data);
            toastr.success(data);
            $('#coursesModal').modal('hide');
            window.location.reload();
        },
        error: function (errors) {
            if (errors.responseJSON)
            {
                $('span[class="text-danger"]').empty();
                var allErrors = errors.responseJSON.errors;
                for (key in allErrors)
                {
                    $('#'+key).empty().append(allErrors[key]);
                    if (key == 'course_categories.0') {
                        $('#course_categories').empty().append('The Course Category field is required.');
                    }

                    if (key == 'teachers_id.0') {
                        $('#teachers_id').empty().append('The Teachers field is required.');
                    }
                }
                $('.submit-btn').attr('disabled', false);
            }
        }
    })
})
// DragNDrop js
$(document).on('keyup', '#discountAmount', function () {
    var discountAmount = Number($(this).val());
    var discountType = $('select[name="discount_type"]').val();
    var price = Number($('input[name="price"]').val());
    var discountErrorMsg = $('#discountErrorMsg');

    if (discountType == '')
    {
        toastr.error('Please select a Discount type.');
        return false;
    }
    if (discountType == 1)
    {
        if (discountAmount > price)
        {
            discountErrorMsg.empty().append('Discount can\'t be greater then Price');
        }else if (discountAmount <= price){
            discountErrorMsg.empty();
        }
    } else if (discountType == 2)
    {
        if (discountAmount > 100)
        {
            discountErrorMsg.empty().append('Discount can\'t be greater then 100%');
        }else if (discountAmount <= 100){
            discountErrorMsg.empty();
        }
    }
})

// show image on change
$(document).on('change', '#courseImage', function () {
    var imgURL = URL.createObjectURL(event.target.files[0]);
    $('#courseImagePreview').attr('src', imgURL).css({
        height: 150+'px',
        width: 150+'px',
        marginTop: '5px'
    });
})

// hide error msgs
$(document).on('keyup', 'input:not(#discountAmount),textarea', function () {
    var selectorId = $(this).attr('name');
    if ($('#'+selectorId).text().length)
    {
        $('#'+selectorId).text('');
    }
})
$(document).on('change', 'select', function () {
    var selectorId = $(this).attr('name');
    if ($('#'+selectorId).text().length)
    {
        $('#'+selectorId).text('');
    }
})

// open model
$(document).on('click', '.open-modal', function () {
    event.preventDefault();

    resetFromInputAndSelect(base_url+"courses", 'coursesForm')
    // $('#summernote').summernote('reset');
    $('#coursesModal').modal('show');
})

// set value to input fields from modal start
var ids = [];
var topicNames = '';
$(document).on('click', '#questionTopicInputField', function () {
    $('#questionTopicModal').modal('show');
    // $('#questionTopicModal').css('display', 'block');
})
$(document).on('click', '.check', function () {
    var existVal = $(this).val();
    var topicName = $(this).parent().text();
    // console.log(existVal);
    // console.log(topicName);
    if ($(this).is(':checked'))
    {
        if (!ids.includes(existVal))
        {
            ids.push(existVal);
            topicNames += topicName+',';

        }
    } else {
        if (ids.includes(existVal))
        {
            ids.splice(ids.indexOf(existVal), 1);
            topicNames = topicNames.replace(topicName+',','');
            // topicNames = topicNames.split(topicName).join('');
        }
    }
})
$(document).on('click', '#okDone', function () {
    $('#questionTopicInputField').val(topicNames.slice(0, -1));
    $('#questionTopic').val(ids);
    $('#questionTopicModal').modal('hide');
})

// show hide test start
$(document).on('click', '.drop-icon', function () {
    var dataId = $(this).attr('data-id');
    if ($(this).find('fa-circle-arrow-down'))
    {
        $(this).html('<i class="fa-solid fa-circle-arrow-up"></i>');
    }
    if($(this).find('fa-circle-arrow-up')) {
        $(this).html('<i class="fa-solid fa-circle-arrow-down"></i>');
    }
    if($('.childDiv'+dataId).hasClass('d-none'))
    {
        $('.childDiv'+dataId).removeClass('d-none');
    } else {
        $('.childDiv'+dataId).addClass('d-none');
    }
})
$(document).on('click', '.close-topic-modal', function () {
    $('#questionTopicModal').modal('hide');
})
// show hide test end

// export json

$(document).on('click', '.export-json', function () {
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        method: "GET",
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            toastr.success('course exported successfully');
        },
    })
})
