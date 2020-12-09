
    <h1>読書ログ</h1>
    <a href="new.php">読書ログを登録する</a>
    <main>
        <section>
            <?php if(count($books > 0)): ?>
                <?php foreach($books as $book): ?>
                    <h2><?php echo escape($book['title']) ?></h2>
                    <div><?php echo escape($book['author']) ?>&nbsp;/&nbsp;<?php echo escape($book['status']) ?>&nbsp;/&nbsp;<?php escape($book['score']) ?></div>
                    <p><?php echo nl2br(escape($book['summary']), false) ?></p>
        </section>
                <?php endforeach; ?>
            <?php else: ?>
                echo '読書ログのデータがありません';
            <?php endif; ?>
    </main>
