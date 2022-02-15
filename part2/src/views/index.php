<h2 class="h3 text-dark mb-4 mt-4">読書ログ</h2>

<a href="new.php" class="btn btn-primary">読書ログを登録する</a>
<main>
    <?php if (count($reviews) > 0) : ?>
        <?php foreach ($reviews as $review) : ?>
            <section class="mt-4 shadow-sm card">
                <div class="card-body">
                    <h3 class="card-title h4 text-dark mb-3"><?php echo escape($review['title']); ?></h3>
                    <div class="small mb-3">
                        <?php echo escape($review['author']); ?>&nbsp;/&nbsp;<?php echo escape($review['status']); ?>&nbsp;/&nbsp;<?php echo escape($review['score']); ?>
                    </div>
                    <div>
                        <?php echo nl2br(escape($review['summary'])); ?>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>読書ログが登録されていません</p>
    <?php endif; ?>
</main>
