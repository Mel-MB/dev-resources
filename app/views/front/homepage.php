<main  class="container main-page">
    <h1><?= $data['title']?></h1>
    <section id="articles" class="d-flex flex-wrap flex-column">
        <?php foreach($data['posts'] as $post):
            $user = $post['firstname'].' '.substr($post['name'],0,1).'.'?>
        <article class="col-sm-6 col-lg-4 d-inline-block p-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><?=$post['content']?></p>
                    <?php if(isset($post['link'])): ?>
                    <a href="<?php $post['link']['url'];?>">
                        <!--Display link preview-->
                    </a>
                    <?php endif ?>
                </div>
                <div class="card-footer post-infos">
                    <p class="text-muted">Posté par <?=$user?> le <?= $post['publication'] = date("d/m/Y")?></p>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </section>
</main>
