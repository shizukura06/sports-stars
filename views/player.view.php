<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!array_key_exists('loaded', $_SESSION)){
    include('views/layouts/header.view.php');
}

?>
<main>
    <div class="ui_cards"><!--    This removes white spaces, that also removes gap spaces between
        --><div class="ui_card_child card_previous" title="Previous Player" onclick="switch_player(this,<?= ($is_allblacks) ?>)" data-player="<?= $player_ids[0] ?>"><span><?= $prev_full_name ?></span></div><!--
        --><div class="ui_card_child card_current" title="Current Player" data-player="0"><span><?= $full_name ?></span></div><!--
        --><div class="ui_card_child card_next" title="Next Player" onclick="switch_player(this,<?= ($is_allblacks) ?>)" data-player="<?= $player_ids[2] ?>"><span><?= $next_full_name ?></span></div>
    </div>
    <h1><?= ($is_allblacks ? "All Blacks Rugby": "NBA Basketball") ?></h1>
    <div class="card">

        <img src="static/images/teams/<?= ($is_allblacks ? "allblacks": (($current_team == "GSW") ? "gsw" : "mem")) ?>.png" alt="<?= ($is_allblacks ? "All Blacks Logo": (($current_team == "GSW") ? "GSW Logo" : "Memphis Logo")) ?>" class="logo" />
        <div class="name">
            <em>#<?= $number ?></em>
            <h2><?= $first_name ?> <strong><?= $last_name ?></strong></h2>
        </div>
        <div class="profile">
            <img src="static/images/players/<?= ($is_allblacks ? "allblacks": "nba") ?>/<?= $image ?>" alt="<?= $first_name ?> <?= $last_name ?>" class="headshot" />
            <div class="features">
                <?php foreach ($featured as $statistic) { ?>
                    <div class="feature">
                        <h3><?= $statistic['label'] ?></h3>
                        <?= $statistic['value'] ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="bio">
            <div class="data">
                <strong>Position</strong>
                <?= $position ?>
            </div>
            <div class="data">
                <strong>Weight</strong>
                <?= $weight ?>KG
            </div>
            <div class="data">
                <strong>Height</strong>
                <?= $height ?>CM
            </div>
            <div class="data">
                <strong>Age</strong>
                <?= $age ?> years
            </div>
        </div>
    </div>
</main>
<div hidden id="global_loading" class="modal">
    <div class="loading-content">
        <span>Please wait...</span>
        <div class="meter animate"  style="margin-top: 7px;margin-bottom: 3px;width:100%; ">
            <span style="width: 100%"></span>
        </div>
    </div>
</div>
<script>
    var is_allblacks = <?= $is_allblacks ?>;
</script>
<?php
if(!array_key_exists('loaded', $_SESSION)) {
    include('views/layouts/footer.view.php');
}
?>
