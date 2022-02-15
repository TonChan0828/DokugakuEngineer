    <h2 class=" h3 text-dark mb-4">読書ログの登録</h2>
    <form action="create.php" method="POST">
        <?php if (count($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="form-group">
            <label for="title">書籍名</label>
            <input class="form-control" type="text" id="title" name="title" value="<?php echo $review['title'] ?>">
        </div>
        <div class="form-group">
            <label for="author">著者名</label>
            <input class="form-control" type="text" id="author" name="author" value="<?php echo $review['author'] ?>">
        </div>
        <div class="form-group">
            <label>読書状況</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status1" name="status" value="未読" <?php echo ($review['status'] === '未読') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status1">未読</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status2" name="status" value="読んでいる" <?php echo ($review['status'] === '読んでいる') ? 'checked' : ''; ?>>
                    <label class="form-check-label" class="mr-3" for="status2">読んでいる</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="status3" name="status" value="読了" <?php echo ($review['status'] === '読了') ? 'checked' : ''; ?>>
                    <label class="form-check-label" class="mr-3" for="status3">読了</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="score">評価(5点満点の整数)</label>
            <input class="form-control" type="number" id="score" name="score" value="<?php echo $review['score'] ?>">
        </div>
        <div class="form-group">
            <label for="summary">感想</label>
            <textarea class="form-control" type="text" id="summary" name="summary" rows="10"><?php echo $review['summary'] ?></textarea>
        </div>
        <button class="btn btn-primary" type="submit">登録する</button>
    </form>
