# Fundeb

Aplicação web para visualização de dados extraidos do FUNDB através dos dados abertos disponibilizados [aqui.](https://www.fnde.gov.br/index.php/financiamento/fundeb/area-para-gestores/dados-estatisticos)
## Preparando o ambiente 
### Faça o clone do projeto
```sh
git clone https://github.com/marcoantoni/fundeb.git && cd fundeb
```

Para criar e importar o banco de dados junto com os dados execute os seguintes comandos. Substitua o USER pelo usuário do Mysql. 
```sh
mysql -uUSER -p -e "create database fundeb";
mysql -uUSER -p -D testdb < database/fundeb.sql
```

### Instalando o Laravel
Para instalar todas as dependências do projeto PHP devemos executar a seguinte linha se o composer estiver instalado globalmente: ```php composer install```.  Caso o composer estiver instalado apenas na pasta do projeto: ```php composer.phar install```.

### Termindando a configuração do Laravel
```sh
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate --ansi
```
Ajuste o arquivo ***.env*** preenchendo as credenciais de acesso aos banco de dados. Para executar iniciar a aplicação. Em ambiente de produção, ajustar o arquivo ***config/database.php***.

Para subir o servidor em ambiente de desenvolvimento:
```sh 
php artisasn serve
```
