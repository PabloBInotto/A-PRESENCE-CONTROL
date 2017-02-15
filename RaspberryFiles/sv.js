var app = require('http').createServer(handler),
 io = require('socket.io').listen(app),
 fs = require('fs'),
 mysql = require('mysql'),
 connectionsArray = [],
 connection = mysql.createConnection({
 host: 'servidor',
 user: 'root',
 password: '',
 database: 'eesh',
 port: 3306
 }),
 POLLING_INTERVAL = 50,
 pollingTimer;
 
//verifica se ha erros ao conectar com db
connection.connect(function(err) {
 // conectado!
 if (err) {
 console.log(err);
 }
});
 
// criando servidor ( localhost:8000 )
app.listen(8000);
 
function handler(req, res) {
 fs.readFile(__dirname + '/show.html', function(err, data) {
 if (err) {
 console.log(err);
 res.writeHead(500);
 return res.end('Error loading client.html');
 }
 res.writeHead(200);
 res.end(data);
 });
}
 
var pollingLoop = function() {
 // Doing the database query
 var datetime = Date.now();
  
 var query = connection.query('SELECT * FROM `grupo` WHERE (`count(``qty``)` % 2) = 0'),
 users = []; // aqui fica o conteudo da consulta
  
 query
 .on('error', function(err) { 
 // Handle error, and 'end' event will be emitted after this as well
 console.log(err);
 updateSockets(err);
 })
 .on('result', function(user) {
 // realizando o looping em cada linha da tabela
 users.push(user);
 })
 ////// Verificando Ausentes ////////
  
 var ausent = connection.query('SELECT * FROM `grupo` WHERE (`count(``qty``)` % 2) > 0'),
 us = []; 
  
 ausent
 .on('error', function(err) { 
 console.log(err);
 updateSockets(err);
 })
 .on('result', function(u) {
 us.push(u);
 })
  
 .on('end', function() {
 // loop on itself only if there are sockets still connected
 if (connectionsArray.length) {
 
 pollingTimer = setTimeout(pollingLoop, POLLING_INTERVAL);
 
 updateSockets({
 users: users,
 us: us
 });
 } else {
 
 console.log('O servidor está parado pois não há ninguém conectado')
 
 }
 });
  
}
io.sockets.on('connection', function(socket) {
 
 console.log('Number of connections:' + connectionsArray.length);
 // começa o loping se alguém tiver conetado
 if (!connectionsArray.length) {
 pollingLoop();
 }
 socket.on('disconnect', function() {
 var socketIndex = connectionsArray.indexOf(socket);
 console.log('socketID = %s got disconnected', socketIndex);
 if (~socketIndex) {
 connectionsArray.splice(socketIndex, 1);
 }
 });
 
 console.log('A new socket is connected!');
 connectionsArray.push(socket);
 
});
 
var updateSockets = function(data) {
 // adding the time of the last update
 var currentdate = new Date(); 
var datetime = "Data: " + currentdate.getDate() + "/"
 + (currentdate.getMonth()+1) + "/"
 + currentdate.getFullYear() + " Hora: "
 + currentdate.getHours() + ":"
 + currentdate.getMinutes() + ":"
 + currentdate.getSeconds();
data.time = datetime;
 console.log('Pushing new data to the clients connected ( connections amount = %s ) - %s', connectionsArray.length , data.time);
 // envia dados para todos os websockets conectados
 connectionsArray.forEach(function(tmpSocket) {
 tmpSocket.volatile.emit('notification', data);
 });
};
 
console.log('Acesse o site em http://localhost:8000');
