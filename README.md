<a href="./LICENSE">![GitHub](https://img.shields.io/badge/license-MIT-green)</a>

# PROJETO - DEVSBOOK[EM DESENVOLVIMENTO]

## :rocket: Tecnologias utilizadas

<li>PHP 7.4</li>
<li>HTML 5</li>
<li>CSS 3</li>

## :loudspeaker: Apresentação

**DEVSBOOK** é um projeto inspirado no facebook para fins de estudo.

## ⚙ Features

- [x] Não utiliza frameworks, apenas PHP puro.

## :clipboard: Instruções para rodar o projeto

### Pré-requisitos

- Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:

<li>![Git](https://git-scm.com)</li>
<li>![Apache](https://www.apachefriends.org/pt_br/index.html)</li>
<li>![MySQL](https://www.apachefriends.org/pt_br/index.html)</li>
<li>Caso não tenha, instle um editor, eu indico o <b>[VSCode](https://code.visualstudio.com/)</li>

### Instalando:

- 1º: Você pode clonar este repositório OU baixar o .zip
  
  ```bash
  # Clonando este repositório
  $ git clone https://github.com/lucaslgr/devs-book
  ```

- 2º: Ao descompactar, é necessário rodar o **composer** pra instalar as dependências e gerar o *autoload*.
  Vá até a pasta do projeto, pelo *prompt/terminal* e execute:
  
  ```bash
  #Instalando as dependências
  $ composer install      
  ```

- 3º: Inicie o Apache e o MySQL via XAMPP ou via terminal e abra no navegador

### Configurando:

- Todos os arquivos de **configuração** e aplicação estão dentro da pasta *src*.

- As configurações de Banco de Dados e URL estão no arquivo *src/Config.php*

- É importante configurar corretamente a constante *BASE_DIR*:
  
  > const BASE_DIR = '/**PastaDoProjeto**/public';

### Utilizando:

- Você deve acessar a pasta *public* do projeto.

- O ideal é criar um ***alias*** específico no servidor que direcione diretamente para a pasta     *public*.

## Modelo de MODEL

```php
<?php
namespace src\models;
use \core\Model;

class Usuario extends Model {

}
```

## :flower_playing_cards:Imagens do Projeto

![Imagem do projeto](https://github.com/lucaslgr/devs-book/blob/master/screenshots/project-devs-book-1.png)

![Imagem do projeto](https://github.com/lucaslgr/devs-book/blob/master/screenshots/project-devs-book-2.png)

![Imagem do projeto](https://github.com/lucaslgr/devs-book/blob/master/screenshots/project-devs-book-3.png)

## :man_technologist: Autoria

Lucas Guimarães

https://lucaslgr.github.io/

https://www.linkedin.com/in/lucas-guimar%C3%A3es-rocha-a30282132/

## :male_detective: Referências

https://www.php.net/