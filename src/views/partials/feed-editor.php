<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?=$base;?>/media/avatars/<?=$user->getAvatar();?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?= $user->getName() ?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            <div class="feed-new-send">
                <img src="<?=$base;?>/assets/images/send.png" />
            </div>

            <form class="feed-new-form" method="POST" action="<?=$base;?>/post/new">
                <input type="hidden" name="body">
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    //Pegando os elementos
    let feedInput = document.querySelector('.feed-new-input'); //div que contém o conteúdo que o usuário digitou
    let feedSubmit = document.querySelector('.feed-new-send'); //div que contem a imagem que representa o botão enviar
    let feedForm = document.querySelector('.feed-new-form'); //form que vai ser preenchido com os dados que o usuario digitou na div para ser enviado

    //Adicionanod evento de click na imagem que representa o botão
    feedSubmit.addEventListener('click', function(){
        //Pegando o que foi digitado na div feedInput
        let value = feedInput.innerText.trim();

        if (value != '') {
            feedForm.querySelector('input[name=body]').value = value;
            feedForm.submit();
        }
    });
</script>