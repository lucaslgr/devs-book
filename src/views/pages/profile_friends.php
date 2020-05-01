<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'friends']) ?>

    <section class="feed">
        <div class="row">
            <div class="box flex-1 border-top-flat">
                <?= $render('profile-header', [
                    'user' => $user,
                    'loggedUser' => $loggedUser,
                    'isFollowing' => $isFollowing
                ]); ?>
            </div>
        </div>

        <div class="row">

            <div class="column">

                <div class="box">
                    <div class="box-body">

                        <div class="tabs">
                            <div class="tab-item" data-for="followers">
                                Seguidores
                            </div>
                            <div class="tab-item active" data-for="following">
                                Seguindo
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-body" data-item="followers">

                                <div class="full-friend-list">
                                    <?php foreach ($user->followers as $follower) : ?>
                                        <div class="friend-icon">
                                            <a href="<?= $base; ?>/profile/<?= $follower->getId() ?>">
                                                <div class="friend-icon-avatar">
                                                    <img src="<?= $base; ?>/media/avatars/<?= $follower->getAvatar(); ?>" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?= $follower->getName(); ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                            <div class="tab-body" data-item="following">

                                <div class="full-friend-list">
                                    <?php foreach ($user->followings as $following) : ?>
                                        <div class="friend-icon">
                                            <a href="<?= $base; ?>/profile/<?= $following->getId() ?>">
                                                <div class="friend-icon-avatar">
                                                    <img src="<?= $base; ?>/media/avatars/<?= $following->getAvatar(); ?>" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?= $following->getName(); ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>

</section>
<?= $render('footer') ?>