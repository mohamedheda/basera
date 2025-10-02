<script>
    document.addEventListener("DOMContentLoaded", function() {
        toastr.error("{{ Session::get('error') }}", "", {
            positionClass: 'toast-top-right',
            timeOut: 5000
        });
    });
</script>
