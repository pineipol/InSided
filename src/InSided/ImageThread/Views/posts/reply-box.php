<?php
    use InSided\ImageThread\Helper\FlashMessenger;
?>
<div id="reply-box-container">
    <div class="flash-messages-container" style="<?= (!FlashMessenger::isEmpty() ? 'display:block' : 'display:none') ?>">
        <?= FlashMessenger::getMessage() ?>
    </div>
    <form action="/post/upload" method="POST" enctype="multipart/form-data">
        <div class="input-container">
            <input type="text" name="post-title" placeholder="Image title" class="image-title">
        </div>
        <div class="upload-container">
            <input type="file" name="post-image" value="Upload image" class="image-button" >
        </div>
        <div class="input-container">
            <input type="submit" name="submit" value="Upload" class="submit-button">
        </div>
    </form>
</div>