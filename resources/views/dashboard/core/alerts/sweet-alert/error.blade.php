<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                toast: true,  
                position: 'top-end', 
                showConfirmButton: false,  
                timer: 5000, 
                timerProgressBar: true, 
            });
        @endif
    });
</script>
