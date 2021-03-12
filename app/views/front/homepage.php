<main  class="container main-page">
    <h1><?= $data['title']?></h1>
    <section id="articles" class="d-flex flex-wrap flex-column">
        <?php foreach($data['posts'] as $post):?>
        <article class="col-sm-6 col-lg-4 d-inline-block p-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><?=$post['content']?></p>
                </div>
                <div class="card-footer post-infos">
                    <p class="text-muted">Posté par <?=$post['pseudo']?> le <?= $post['publication'] = date("d/m/Y")?></p>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </section>
</main>
