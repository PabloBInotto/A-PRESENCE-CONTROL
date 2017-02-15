'use strict';
var pcsc = require('pcsclite');
var mysql = require('mysql'),
connectionsArray = [],
connection = mysql.createConnection({
host : 'servidor',
user : 'sua_sebha',
password : '123456',
database : 'sua_base_de_dados'
});
 
// If there is an error connecting to the database
connection.connect(function(err) {
// connected! (unless `err` is set)
 if (err) {
 console.log(err);
 }
});
 
var pcsc = pcsc();
// PC/SC interface.
pcsc.on('reader', function(reader) {
console.log('Reader detected:', reader);
reader.on('error', function(err) {
console.log('Error(', reader.name, '):', err.message);
});
reader.on('status', function(status) {
console.log('Status(', reader.name, '):', status);
// Check changes.
var changes = this.state ^ status.state;
if (changes) {
// Card removed.
if ((changes &amp;amp; this.SCARD_STATE_EMPTY) &amp;amp;&amp;amp; (status.state &amp;amp; this.SCARD_STATE_EMPTY)) {
console.log('Status(', reader.name, '): Card removed');
reader.disconnect(reader.SCARD_LEAVE_CARD, function(err) {
if (err) {
console.log('Error(', reader.name, '):', err);
}
else {
console.log('Status(', reader.name, '): Disconnected');
}
});
}
// Card inserted.
else if ((changes &amp;amp; this.SCARD_STATE_PRESENT) &amp;amp;&amp;amp; (status.state &amp;amp; this.SCARD_STATE_PRESENT)) {
console.log('Status(', reader.name, '): Card inserted');
reader.connect({ share_mode : this.SCARD_SHARE_SHARED }, function(err, protocol) {
if (err) {
console.log('Error(', reader.name, '):', err);
}
else {
console.log('Protocol(', reader.name, '):', protocol);
/*
Read card UID: [0xFF, 0xCA, 0x00, 0x00, 0x00]
UID is specified in the ISO 14443 T=CL transport protocol while APDU's are specified in the ISO 7816 application layer protocol.
"Get Data Command" is defined in PCSC 3 v2. If your driver is PCSC v2 compliant, you can get UID using it:
Class = 0xFF
INS = 0xCA
P1 = 0x00
P2 = 0x00
Le = 0x00 (return full length: ISO14443A single 4 bytes, double 7 bytes, triple 10 bytes, for ISO14443B 4 bytes PUPI, for 15693 8 bytes UID)
Expected response: Data+SW1SW2
*/
var message = new Buffer([0xFF, 0xCA, 0x00, 0x00, 0x00]);
reader.transmit(message, 40, protocol, function(err, data) {
if (err) {
console.log('Error(', reader.name, '):', err);
} else {
/* buf.readUIntLE(offset, byteLength[, noAssert])
Set noAssert to true to skip validation of value and offset. Defaults to false.
*/
var lastRead = data.readUIntBE(0, 6, true).toString(16);
var post = {evento: lastRead};
var sql = connection.query('SELECT COUNT (*) AS tt FROM `event` WHERE `rfid` = ?', lastRead, function(err, rows, results){
if (err)throw err;
if (rows[0].tt &amp;lt; 1){
console.log(lastRead + ' Nao resgistrado');
}else{
var query = connection.query('INSERT INTO ck SET ?', post, function(err, resuslt){
});
console.log(query.sql);
}
});
console.log('Status(', reader.name, '): Read:', data, ' toString:', lastRead);
}
});
}
});
}
}
});
 
reader.on('end', function() {
console.log('Status(', reader.name, '): Removed');
 
// Release resources.
reader.close();
pcsc.close();
});
});
pcsc.on('error', function(err) {
console.log('Error( PCSC ): ', err);
});
