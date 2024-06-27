{{--    date time picker from template--}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">

{{--datetime picker--}}
<script src="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js"></script>
<script src="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
{{--<script src="{{ asset('/') }}backend/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-backup.min.js"></script>--}}


<script>
    $(function () {
        $('#dateTime').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm',
            minDate : new Date()
        });
    });
</script>
{{--data-dtp="dtp_Nufud"--}}


{{--plugin two--}}
{{--<script src="{{ asset('/') }}backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>--}}
{{--$("#datetimepicker").datetimepicker({format: "yyyy-mm-dd hh:ii", autoclose: !0});--}}
