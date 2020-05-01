<?= $render('header', ['loggedUser' => $loggedUser]); ?>

<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'settings', 'countFriends' => '33']); ?>
    <section class="feed mt-10">
        <form id="user-config" method="POST" action="<?= $base; ?>/settings">
            <div class="row">
                <div class="column pr-5">

                    <h1>Configurações</h1>
                    <?php if (!empty($flash)) : ?>
                        <div class="flash"><?= $flash; ?></div>
                    <?php endif; ?>

                    <div class="config-file">
                        <span>Novo Avatar:</span>
                        <input type="file" name="avatar" />
                    </div>
                    <div class="config-file">
                        <span>Nova Capa:</span>
                        <input type="file" name="cover" />
                    </div>
                    <hr />

                </div>

                <!-- <div class="column side pl-5">
                    <?= $render('right-side'); ?>
                </div> -->
            </div>

            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Nome Completo:</label>
                    <input type="text" name="name" value="<?= $loggedUser->getName(); ?>" class="input-field"/>
                </div>
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Data de Nascimento:</label>
                    <input type="text" name="birthdate" class="birthdate input-field" value="<?= date('d/m/Y', strtotime($loggedUser->getBirthDate())); ?>" />
                </div>
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">E-mail:</label>
                    <input type="email" name="email" value="<?= $loggedUser->getEmail(); ?>" class="input-field"/>
                </div>
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Cidade:</label>
                    <input type="text" name="city" value="<?= $loggedUser->getCity(); ?>"  class="input-field"/>
                </div>
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Trabalho:</label>
                    <input type="text" name="work" value="<?= $loggedUser->getWork(); ?>"  class="input-field"/>
                </div>
            </div>
            <hr class="mt-10" />
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Nova Senha:</label>
                    <input type="password" name="new-password" class="password input-field" />
                </div>
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Confirmar Nova Senha:</label>
                    <input type="password" name="confirm-password" class="match-password input-field" />
                </div>
            </div>
            <div class="row mt-10">
                <div class="config-col">
                    <input class="button btn-update" type="submit" value="Salvar" />
                </div>
            </div>
        </form>
    </section>
</section>
<?= $render('footer') ?>

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.querySelector('input[name=birthdate]'), {
            mask: '00/00/0000'
        }
    );


    document.querySelector('input[name=confirm-password]').addEventListener('keyup', (e) => {
        var pass = document.querySelector('.password').value;

        if (e.target.value != pass) {

            document.querySelector('.password').style.background = "#ff6969";
            e.target.style.background = "#ff6969";
            document.getElementById('user-config').onsubmit = function(e) {
                return false;
            }
        } else {
            document.querySelector('.password').style.background = "#00FF00";
            e.target.style.background = "#00FF00";
            document.getElementById('user-config').onsubmit = function(e) {
                return true;
            }
        }
    })
</script>