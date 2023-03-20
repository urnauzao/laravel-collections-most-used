# Setup

1- Clone o projeto<br>

2- Instale as dependências do Composer<br>

3- Esteja com o Docker em execução<br>

4- Suba o projeto via Sail usando:<br>
4.1- sail build<br>
4.2- sail up -d<br>

5- Execute a migrate
`sail artisan migrate`

6- Execute a seed
`sail artisan db:seed --class=ProdutoSeeder`
