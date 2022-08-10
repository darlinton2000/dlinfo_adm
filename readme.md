Necessário verificar se o GD está ativo no servidor.

Criar um arquivo com o código abaixo e teste.
<?php
if (extension_loaded('gd')) {
print 'GD ativo';
} else {
print 'GD inativo';
}
phpinfo();
?>

Se retornar "GD inativo", verifique no XAMPP, no arquivo php.ini está desmarcado:
extension=gd

Não pode ter ";", ponto e vírgula no início da linha.

No Xampp instalado no Windows, é necessário ativar "ext", retirando o ponto e vírgula ";" no início da linha.
extension_dir = "ext"

Após as alterações, reinicie o servidor e teste se carregar o GD.