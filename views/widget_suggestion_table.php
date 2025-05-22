<?php for ($i = 0; $i < 9; $i++) { ?>
    <div data-suggestion="<?= $i ?>">
        <div class="domain-item">
            <div class="domain-left">
                <div class="suggestionLoader">
                    <div class="suggestionItem"></div>
                </div>
                <div class="domain-name"><?= $widget->{"$i"} ?></div>
            </div>
            <div class="domain-right">
                <div class="price"></div>
            </div>
        </div>
    </div>
<?php } ?>