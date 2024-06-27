<!-- JQUERY JS -->
{{--<script src="{{ asset('/') }}backend/assets/plugins/jquery/jquery.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('/') }}backend/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="{{ asset('/') }}backend/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>--}}

<!-- SIDE-MENU JS -->
<script src="{{ asset('/') }}backend/assets/plugins/sidemenu/sidemenu.js"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="{{ asset('/') }}backend/assets/plugins/p-scroll/perfect-scrollbar.js"></script>
<script src="{{ asset('/') }}backend/assets/plugins/p-scroll/pscroll.js"></script>

<!-- STICKY JS -->
<script src="{{ asset('/') }}backend/assets/js/sticky.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="{{ asset('/') }}backend/assets/plugins/select2/select2.full.min.js"></script>



<!-- INTERNAL DATA-TABLES JS-->
{{--include dataTable.blade where required--}}





<!-- COLOR THEME JS -->
<script src="{{ asset('/') }}backend/assets/js/themeColors.js"></script>

<!-- CUSTOM JS -->
<script src="{{ asset('/') }}backend/assets/js/custom.js"></script>

<!-- CUSTOM PLUGIN CALL JS -->
<script src="{{ asset('/') }}backend/assets/js/custom/plugin-call.js"></script>

<!-- SWITCHER JS -->
<script src="{{ asset('/') }}backend/assets/switcher/js/switcher.js"></script>

<!-- custom added js -->
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Sweet Alert JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>--}}

{{--    sweet alert js--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--    delete popup with sweet alert--}}
<script>
    $(document).on('click', '.data-delete-form', function () {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                $(this).parent().submit();
            }

        })
    })
</script>
<script>
    $(document).on('click', 'input[type="submit"]', function () {
        if (!$(this).hasClass('data-delete-form'))
        {
            $(this).attr('disabled', true);
            $(this).closest('form').submit();
        }
    })
    $(document).on('click', 'button[type="submit"]', function () {
        if (!$(this).hasClass('data-delete-form') )
        {

            $(this).attr('disabled', true);
            $(this).closest('form').submit();
        }
    })
</script>

<script>
    let base_url = {!! json_encode(url('/')) !!}+"/";
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr, settings) {
            if (!settings.crossDomain) {
                settings.url = settings.url.replace(/^http:/, 'https:');
            }
        }
    });
</script>
<script>
    const date = new Date();
    // let currentDateTime = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes();
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Adding leading zero if needed
    const day = date.getDate().toString().padStart(2, '0'); // Adding leading zero if needed
    const hours = date.getHours().toString().padStart(2, '0'); // Adding leading zero if needed
    const minutes = date.getMinutes().toString().padStart(2, '0'); // Adding leading zero if needed

    const currentDateTime = `${year}-${month}-${day} ${hours}:${minutes}`;
</script>
<script>

    function resetFromInputAndSelect(formAction = null, formId) {
        $("input:not(#formMethod,#formToken,[name='status'],[name='is_paid'],[name='is_featured'],[name='is_approved'],.check,[data-dtp='dtp_Nufud'])").each(function () {
            $(this).val('');
        })
        $('select option').each(function () {
            if ($(this).is(':selected'))
            {
                $(this).removeAttr('selected');
            }
        })
        $('form img').attr('src', '');
        $("textarea").each(function () {
            $(this).text('');
        })
        $('#'+formId).attr('action', formAction)
        $('#formMethod').remove()
        $('.select2').select2({
            placeholder: $(this).attr('data-placeholder'),
            allowClear: true
        });
    }
    function changeStatus(model_name, id, element) {
        $.ajax({
            url: "{{ route('change-status') }}",
            method: "POST",
            data: {model_name: model_name, id:id},
            dataType: "JSON",
            success: function (message) {
                console.log(message);
                if(message.status == 'success')
                {
                    element.text(message.message).css('backgroundColor', '#8fbd56');
                    toastr.success('Status Changed Successfully.');
                }
            },
            error: function (error) {
                toastr.error(error);
            }
        })
    }
</script>

@if(Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif
@if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif
@if(Session::has('customError'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ Session::get('customError') }}",
            icon: 'error',
            confirmButtonText: 'Ok'
        })
    </script>
@endif


@stack('script')
@yield('script')
