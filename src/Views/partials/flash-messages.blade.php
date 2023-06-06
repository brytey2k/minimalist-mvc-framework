<?php use App\Classes\SessionHelper; ?>

<div class="col-md-12">
    <?php if(SessionHelper::exists('messages')): ?>
        <div class="alert alert-<?php echo SessionHelper::get('message_type'); ?>">
            <?php
            echo SessionHelper::get('messages');
            SessionHelper::remove('messages');
            SessionHelper::remove('message_type');
            ?>
        </div>
    <?php endif; ?>
</div>