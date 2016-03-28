<div id="post-list-container">
    <?php 
    foreach ($postCollection as $post) {
        require ROOT_DIR . $config['application']['viewsDir'] . 'posts/post-partial.php';
    }
    ?>
</div>