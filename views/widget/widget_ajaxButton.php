<button id="ajaxButton" value="orderNew" style="flex: 3">Ajax run</button>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let successFn = function(response) {
        console.log(response);
        $("#drawHere").html(response.data.message); // nếu wp_send_json_success(['message' => '...'])
    };
    let errorFn = function(response) {
        console.log("Lỗi server")
    };

    $("#ajaxButton").on("click", function(event) {
        event.preventDefault();

        $.ajax({
            url: "http://localhost/etb/wp-admin/admin-ajax.php",
            type: "POST",
            data: {
                action: "my_ajax_action",
                custom_param: "giá trị gì đó"
            },
            success: successFn,
            error: errorFn
        });
    });
</script>