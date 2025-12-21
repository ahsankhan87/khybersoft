<h2><?= esc($title) ?></h2>
<a href="<?php echo site_url('/news/new') ?>">Add News</a>
<?php if ($news_list !== []): ?>

    <?php foreach ($news_list as $news_item): ?>

        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <p><a href="<?php echo site_url("/news/{$news_item['slug']}") ?>">View article</a></p>

    <?php endforeach ?>

<?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>