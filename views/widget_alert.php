<style>
    .custom-alert {
        padding: 10px 20px;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.375rem;
        position: relative;
        font-family: sans-serif;
        font-size: 1rem;
    }

    .custom-alert-success {
        color: #0f5132;
        background-color: #d1e7dd;
        border-color: #badbcc;
    }

    .custom-alert-warning {
        color: #664d03;
        background-color: #fff3cd;
        border-color: #ffecb5;
    }

    .custom-alert-danger {
        color: #842029;
        background-color: #f8d7da;
        border-color: #f5c2c7;
    }

    .custom-alert .close-btn {
        position: absolute;
        top: 0;
        height: 100%;
        right: 1rem;
        background: none;
        border: none;
        font-size: 25px;
        color: inherit;
        cursor: pointer;
    }
</style>

<div class="custom-alert custom-alert-warning" style="border: none; background-color: <?= $color ?>; color: <?= $text ?>" id="my-alert">
    <span id="alertMe"><?= $msg ?? '...' ?></span>
    <button class="close-btn" onclick="document.getElementById('my-alert').style.display='none'">&times;</button>
</div>