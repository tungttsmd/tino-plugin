<div id="drawHere">
    <form method="POST" style="max-width: 100%; margin: 20px 0;">
        <div style="margin-top: 10px; display: flex; gap: 20px">
            <input type="text" id="domain" name="domain" placeholder="nhập tên miền bạn muốn mua: tenmien.vn" style="padding-left: 10px; padding-right: 10px; width: 100%; flex: 7" value="<?= $widget->data->domain ?? '' ?>">
            <button type="submit" name="button" value="orderNew" style="flex: 3">Kiểm tra</button>
            <!-- <button type="button" id="ajaxButton" value="orderNew" style="flex: 3">Ajax run</button> -->
        </div>
    </form>
</div>
<!-- <div class="ajaxMe" style="border: 1px solid blue">

    <form id="myForm">
        <input type="text" name="username" placeholder="Tên người dùng">
        <input type="submit" value="Gửi">
    </form>

    <div id="result"></div>

</div> -->

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    class ajaxPost {
        constructor(url = "", timer = 300) {
            this.urlInput = url;
            this.timerInput = timer;
        }

        ajaxObj(successFn, errorFn, input) {
            return {
                url: this.urlInput,
                type: "POST",
                data: input,
                success: successFn,
                error: errorFn,
            };
        }

        run(successFn, errorFn, input) {
            return setTimeout(() => {
                $.ajax(this.ajaxObj(successFn, errorFn, input));
            }, this.timerInput);
        }
    }
    class buttonAjax extends ajaxPost {
        constructor(selector, successFnInput, postData, timeout) {
            super("", timeout);
            this.ajaxSelector = selector;
            this.ajaxPostData = postData;
            this.successFnInput = successFnInput;
        }

        syncRun() {
            let timer;
            $(this.ajaxSelector).on("click", (event) => {
                event.preventDefault();
                clearTimeout(timer);

                let successFn = this.successFnInput;
                let errorFn = function() {
                    $(".displayAjax").html("Lỗi kết nối server.");
                };

                timer = this.run(successFn, errorFn, this.ajaxPostData);
            });
        }
    }
    const button = new buttonAjax("button[name='button']", function(response) {
        console.log('okss');
        $(".displayAjax").html(response);
    }, {
        pika: "piripima",
        button: "orderOther"
    }, 300);
    button.syncRun();
</script> -->