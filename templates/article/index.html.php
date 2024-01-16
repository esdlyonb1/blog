<h1>Les articles</h1>

<?php foreach ($articles as $article) : ?>

<div class="border border-dark">

    <h2>Titre : <?= $article->getTitle() ?></h2>
    <p>Contenu : <?= $article->getContent() ?></p>

    <a href="?type=article&action=show&id=<?= $article->getId() ?>" class="btn btn-primary">Voir</a>

</div>



<?php endforeach; ?>
