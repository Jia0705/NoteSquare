<?php if ( isset( $_SESSION["success"] ) ) : ?>
    <div class="alert alert-success" role="alert">
    <?= e($_SESSION["success"]); ?>
    <?php 
        // remove success after it's shown
        unset( $_SESSION["success"] ); 
    ?>
    </div>
<?php endif; ?>
