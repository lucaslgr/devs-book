<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'profile']); ?>

    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">
                <h4>Você pesquisou por: <?= $searchTerm ?></h4>

                <div class="full-friend-list">
                    <?php foreach ($users as $user) : ?>
                        <div class="friend-icon">
                            <a href="<?= $base; ?>/profile/<?= $user->getId() ?>">
                                <div class="friend-icon-avatar">
                                    <img src="<?= $base; ?>/media/avatars/<?= $user->getAvatar(); ?>" />
                                </div>
                                <div class="friend-icon-name">
                                    <?= $user->getName(); ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="column side pl-5">
                <?= $render('right-side'); ?>
            </div>
        </div>

    </section>

</section>
<?= $render('footer') ?>