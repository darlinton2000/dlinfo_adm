<h2>Sistema de Gestão de Dados - DLInfo ADM</h2>

Linguagem de programação: PHP 8.1.5<br>
Banco de Dados: MariaDB<br>
Bibliotecas: PHPMailer 6.6.3<br>

<hr>

Necessário verificar se o GD está ativo no servidor.

Criar um arquivo com o código abaixo e teste.

if (extension_loaded('gd')) {
print 'GD ativo';
} else {
print 'GD inativo';
}
phpinfo();

Se retornar "GD inativo", verifique no XAMPP, no arquivo php.ini está desmarcado:
extension=gd

Não pode ter ";" ponto e vírgula no início da linha.

No Xampp instalado no Windows, é necessário ativar "ext", retirando o ponto e vírgula ";" no início da linha.
extension_dir = "ext"

Após as alterações, reinicie o servidor e teste se carregar o GD.

<hr/>

Tela de Login 

![01 - Tela de Login](https://user-images.githubusercontent.com/46008964/219245247-d4e2739d-178e-4a38-bd5f-2738ac78ee01.png)

Tela de Dashboard

![02 - Tela de Dashboard](https://user-images.githubusercontent.com/46008964/219246216-5ad51e56-f141-4778-b76a-b340bea5463f.png)

03 - Tela Cadastrar Usuário

![03 - Tela Cadastrar Usuário](https://user-images.githubusercontent.com/46008964/219248203-adb3493f-3711-4b49-aab5-0ef77bb55ae5.png)

