<script>
    document.addEventListener("DOMContentLoaded", function() {
        toastr.success("{{ Session::get('success') }}", "", {
            positionClass: 'toast-top-right',
            timeOut: 5000
        });
    });
</script>
