<div class="box-body">
    <div class="profile-cover" style="background-image: url('<?= $base; ?>/media/covers/<?= $user->getCover(); ?>');"></div>
    <div class="profile-info m-20 row">
        <div class="profile-info-avatar">
            <a href="<?= $base ?>/profile/<?= $user->getId(); ?>">
                <img src="<?= $base; ?>/media/avatars/avatar.jpg" />
            </a>
        </div>
        <div class="profile-info-name">
            <div class="profile-info-name-text">
                <a href="<?= $base ?>/profile/<?= $user->getId(); ?>">
                    <?= $user->getName(); ?>
                </a>
            </div>
            <div class="profile-info-location"><?= $user->getCity(); ?></div>
        </div>
        <div class="profile-info-data row">
            <div class="profile-info-item m-width-20">
                <?php if ($user->getId() != $loggedUser->getId()) : ?>
                    <a href="<?= $base ?>/profile/<?= $user->getId(); ?>/follow" class="button">
                        <?= ($isFollowing) ? ('Deixar de Seguir') : ('Seguir') ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="profile-info-item m-width-20">
                <a href="<?= $base; ?>/profile/<?= $user->getId(); ?>/friends">
                    <div class="profile-info-item-n"><?= count($user->followers) ?></div>
                    <div class="profile-info-item-s">Seguidores</div>
                </a>
            </div>
            <div class="profile-info-item m-width-20">
                <a href="<?= $base; ?>/profile/<?= $user->getId(); ?>/friends">
                    <div class="profile-info-item-n"><?= count($user->followings) ?></div>
                    <div class="profile-info-item-s">Seguindo</div>
                </a>
            </div>
            <div class="profile-info-item m-width-20">
                <a href="<?= $base; ?>/profile/<?= $user->getId(); ?>/photos">
                    <div class="profile-info-item-n"><?= count($user->photos) ?></div>
                    <div class="profile-info-item-s">Fotos</div>
                </a>
            </div>
        </div>
    </div>
</div>