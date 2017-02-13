# CONTROLE-DE-PRESENÇA-COM-RASPBERRY-NODE-JS-MYSQL-SOCKET.IO-ACR122U

* Demostração: https://www.youtube.com/watch?v=j0nkCkhKzPU

Para realizar esse projeto você vai precisar dos seguintes itens abaixo:
* Leito RFID ACR122u
* Tags RFID
* Uma placa Raspberry pi
Não vou explicar como fazer a configuração do sistema operacional (OS) mas é muito simples e tem vários posts sobre esse assunto na net; Eu usei o OS Wkenzy versão 2016
* Um SD card de no minimo 4GB
* Um cabo HDMI
* Um monitor com entrada digital HDMI
Para exibir  as respostas no nosso sistema.
* Teclado, mouse

* Primeiro vamos verificar se tudo esta atualizado em nosso OS.

~$ sudo apt-get install update && apt-get upgrade

* após digitar os códigos digite enter

~$ sudo apt-get install libpcsclite1
~$ sudo apt-get install libpcsclite-dev
~$ sudo apt-get install pcscd
~$ sudo apt-get install pcsctools
~$ sudo apt-get install libusb-0.1-4
~$ sudo apt-get install libusb-dev
~$ sudo apt-get install libusb-1.0.0-dev

Agora o driver para o dispositivo de leitura ACR122u:

http://www.acs.com.hk/download-driver-unified/6258/ACS-Unified-Driver-Lnx-Mac-108-P.zip.unzip

— Instalação do Driver do fornecedor ACS —

Após baixar o pacote zipado descompacte seguindo os passos abaixo:

~$ ls // para visualizar a pasta ACS-Unified-Driver-x.x.x  // algo parecido com isso, os “x” no final representa a versão que você acabou de baixar

~$ cd ACS-Unified-Driver-x.x.x  // digite cd e o nome da pasta para acessar-la

~$ ls // para visualizar os arquivos dentro da pasta

acsccid-x.y.z.tar.bz2 // x.y.z representam os números logo após o nome do arquivo

~$ tar -jxvf acsccid-x.y.z.tar.bz2 // digite e tecle enter para descompactar o arquivo

~$ cd acsccid-x.y.z // para acessar a pasta que foi descompactada

Após acessar a pasta digite os comandos abaixo para instalar o driver

~$  ./configure

~$ make

~$ make install

A instalação leva alguns minutos.

Agora será necessário configurar o arquivo libccid_info.plist no diretorio cd /etc

~$ cd

~$ cd /etc

~$ sudo nano libccid_info.plist

Encontre e altere a a seguinte linha no arquivo:

<key>ifDriverOptions</key>
<string>0x0000</string>

para

<key>ifDriverOptions</key>
<string>0x0001</string>

Ctrl + x e depois pressione y para salvar!

~$ cd // para retornar a pasta raiz (/home/pi..)

Agora vamos instalar nfc-tools, para isso siga os passos abaixo:

~$ wget https://bintray.com/artifact/download/nfc-tools/sources/libnfc-1.7.1.tar.bz2

~$ tar xjf libnfc-1.7.1.tar.bz2

~$ cd libnfc-1.7.1

~$ ./configure –with-drivers=all –prefix=/usr –sysconfdir=/etc

~$ make

~$ sudo make install

Agora vamos configurar o arquivo blacklist.conf

~$ cd // para retornar a pasta raiz (/home/pi..)

~$ sudo nano /etc/modprobe.d/blacklist.conf

digite os códigos a seguir:

blacklist pn533

blacklist nfc

Ctrl + x e depois pressione y para salvar!

~$ sudo modprobe -r pn533 nfc

~$ sudo reboot

Para verificar se tudo deu certo até aqui digite:

~$ sudo nfc-list // deve parecer o seu leito ACR122u

~$ nfc-scan-device -v

Acredito que tudo deve ter dado certo até aqui! 
Em caso de problemas deixe um comentário vamos solucionar o problema.

Agora vamos instalar o node js seguindo os passos abaixo para começar a segunda fase onde vamos ler os dados usando o ACR122u salvar o dados em um banco de dados MYSQL. 
Eu utilizei o mysql por ter o XAMPP instalado em um PC e usei como servidor remoto.

Caso você queira fazer da mesma forma instale o xampp e crie um usuário para ter acesso remoto, neste link:
http://pt.wikihow.com/Instalar-o-XAMPP-para-Windows
explica como instalar o xampp e nesse outro:
https://www.youtube.com/watch?v=3ADH79DDAXo
como configurar usuário e dar permissões.

Vamos instalar o nodejs!

~$ curl -sL https://deb.nodesource.com/setup_5.x | sudo -E bash –

~$ sudo apt-get install -y nodejs

~$ sudo apt-get install -y build-essential

~$ apt-get install nodejs nodejs-legacy

Para mais informações de como instalar o node js acesse o site oficial nodejs.org.

para verificar se tudo foi instalado corretamente digite os códigos abaixo:

~$ node -v

v0 . 12 . 9 

~$ npm -v

2 . 14 . 9 // Vai obter algo parecido com isso.

Agora crie a pasta rfid digitando:

~$ cd // para voltar a pasta raiz

~$ mkdir rfid // para criar a pasta

~$ cd rfid // para entrar na pasta

Agora vamos instalar as dependências para o projeto dentro da pasta rfid

~$ npm install express

~$ npm install pcsclite

~$ npm install socket.io

~$ npm install mysql

Abra o phpmyadmin em http://localhost:8080/phpmyadmin/ no pc que você instalou o xampp e crie as tabelas usando os códigos sql.sql;

Com leitor RFID ACR122U tudo conectado no raspberry, digite os códigos abaixo, vamos testar se tudo deu certo:

1º abra o terminal no raspberry;

2º  Inicie o middleware new.js que será responsável pela leitura e gravação dos códigos rfid das tags no mysql:

~$ cd rfid

~$ node new

3º Em um outro terminal inicie o servidor http do node:

~$ cd rfid

~$ node sv-http

 4º Abra o navegador e acesse  o html que criamos por ultimo, a pagina que vai exibir que esta presente ou ausente. No vavegador digite: http://localhost:8000

* Colocar rasp em modo Kiosk e iniciar automaticamente o servidor sv-http e já abrir a pagina para apresentar nosso controle de presença:

Primeiro temos que instalar o chromium

~$ sudo apt-get install chromium x11-xserver-utils unclutter

Agora vamos editar o aquivo autostart

~$ sudo nano /etc/xdg/lxsession/LXDE-pi/autostart

O arquivo deve ficar como as linhas abaixo:

@xscreensaver -no-splash

@xset s off
@xset -dpms
@xset s noblank

@lxterminal –command “node /home/pi/rfid/sv-http.js”

@sed -i ‘s/”exited_cleanly”: false/”exited_cleanly”: true/’ ~/.config/chromium/Default/Preferences
@chromium –noerrdialogs –kiosk http://www.page-to.display

Ctrl + C  – y  – enter

Agora vamos fazer o raspberry ligar sem uso de teclado e mouse

~$ sudo nano /etc/rc.local

su -l pi -c startx // deu certo

Adicionar linha antes de exit 0

Ctrl + C  – y  – enter
