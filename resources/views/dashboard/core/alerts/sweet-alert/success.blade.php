<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                toast: true,  
                position: 'top-end',  
                showConfirmButton: false,  
                timer: 5000, 
                timerProgressBar: true,  
            });
        @endif
    });
</script>
