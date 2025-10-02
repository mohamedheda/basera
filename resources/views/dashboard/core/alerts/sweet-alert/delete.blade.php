<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).off("click", ".btn-delete").on("click", ".btn-delete", function(e) {
            e.preventDefault();
            let route = $(this).data("route");
            let itemId = $(this).data("id");
            confirmDelete(route, itemId);
        });
    });


    function confirmDelete(route, itemId) {

        Swal.fire({
            title: "@lang('dashboard.Are you sure?')",
            text: "@lang('dashboard.This action cannot be undone!')",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "@lang('dashboard.Yes, delete it!')",
            cancelButtonText: "@lang('dashboard.Cancel')"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: route,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {

                        if (response.data === true) {
                            $(`#row-${itemId}`).slideUp(300, function() {
                                $(this).remove();

                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                            });


                            // .then(() => location.reload());
                        } else {
                            Swal.fire("@lang('dashboard.Error!')", response.message || "@lang('dashboard.Something went wrong!')",
                                "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("🚨 خطأ في الطلب:", xhr.responseText);
                        Swal.fire("@lang('dashboard.Error!')", "@lang('dashboard.Unable to delete item.')", "error");
                    }
                });

            } else {
                console.log("⛔ تم إلغاء الحذف.");
            }
        });
    }
</script>
