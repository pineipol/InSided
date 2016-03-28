<div class="post-container">
    <div class="post-title-container">
        <?= $post->getTitle() ?>
    </div>
    <div class="post-image-container">
        <a href="/<?= $post->getPath() ?>" target="_blank">
            <img class="post-image" src="/<?= $post->getThumbPath() ?>">
        </a>
    </div>
</div>