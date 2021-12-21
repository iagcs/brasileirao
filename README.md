## Sobre o projeto

Esta aplicação Laravel tem como objetivo resolver o "problema" reportado pelo teste para Desenvolvedor do Grupo Bernoulli.

Para seu desenvolvimento, foi utilizado o padrão de projeto MVC, nativo do laravel além de Form Request para garantir a segurança da aplicação 
também no backend, e cobertura completa com testes unitário utilizando o PHPUnit.


## Como iniciar o projeto

Para utilizar o projeto deve-se ter previamente instalado em sua máquina:
- **[Php](https://www.php.net/downloads.php)**
- **[Composer](https://getcomposer.org/)**
- **[Mysql](https://www.mysql.com/)** (ou qualquer outro banco de dados, mas com suas devidas adaptações no arquivo .env)
- **[Git](https://git-scm.com/downloads)**


Para baixar o projeto utilize em seu terminal:

``
    $ git clone https://github.com/iagcs/brasileirao.git
``

Em seguida entre na raiz do projeto:

``
    $ cd test
``

Baixe as dependências do projeto:

``
    $ composer install
``

Após a instalação utilize para preencher o .env da aplicação:

``
    $ cp .env.example .env
``

Abra o arquivo .env que foi copiado do exemplo e o preencha com as informações do seu banco de dados.

Gere uma key para a aplicação:

``
   $ php artisan key:generate
``

Faça a geração do banco de dados com:

*Isso vai popoular o banco também.
``
    $ php artisan migrate
``

Rode o projeto:

``
  $ php artisan serve
``

Acesse a aplicação em: http://localhost:8000

Para rodar os testes da aplicação rode o comando:

``
    $ vendor/bin/phpunit
``

Caso prefira rodar com docker, rode o comando 

``
    $ docker-compose build
``

E em seguida 

``
    $ docker-compose up
``

Para acessar o bash do container:

``
    $ docker container exec -it brasileirao-app /bin/bash
``

Agora é so rodar os comandos ditos acima normalmente.
