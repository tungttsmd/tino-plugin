jQuery(document).ready(function ($) {
  $("#my-ajax-form").on("submit", function (e) {
    e.preventDefault();
    $.post(
      ajaxurl,
      {
        action: "my_form_handler",
        data: $(this).serialize(),
      },
      function (response) {
        $("#form-result").html(response.data.html); // Cập nhật form mới
      }
    );
  });
  $("#ajaxButton").on("click", function (event) {
    event.preventDefault();
    let successFn = function (response) {
      console.log(response);
      $("#drawHere").html(response.data.message); // nếu wp_send_json_success(['message' => '...'])
    };
    let errorFn = function (response) {
      console.log("Lỗi server");
    };
    $.ajax({
      url: "http://localhost/etb/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        action: "my_ajax_action",
        custom_param: "Confirm",
        color: "warning",
      },
      success: successFn,
      error: errorFn,
    });
  });
});
