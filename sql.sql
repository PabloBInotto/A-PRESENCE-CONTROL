--------------------------------------------
-- Cria uma base de dados antes no mysql ---
--------------------------------------------

--------------------------------------------
----------- Cria a tabela ck ---------------
--------------------------------------------

CREATE TABLE IF NOT EXISTS `ck` (
`ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`evento` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`qty` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--------------------------------------------
----------- Cria a tabela event-------------
--------------------------------------------

CREATE TABLE IF NOT EXISTS `event` (
 `nome` varchar(100) DEFAULT NULL,
 `foto` varchar(100) DEFAULT NULL,
 `rfid` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
 `dept` varchar(20) NOT NULL,
 `turno` varchar(10) NOT NULL,
 `divi` varchar(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `Qty` int(1) NOT NULL DEFAULT '1',
 `fone` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--------------------------------------------
------------- Cria a view evento -----------
--------------------------------------------

CREATE VIEW `coutbyid` AS select `ck`.`evento` AS `evento`,
count(`ck`.`qty`) AS `count(``qty``)` 
from `ck` 
group by `ck`.`evento`;


--------------------------------------------
------------- Cria a view grupo ------------
--------------------------------------------

CREATE VIEW `grupo` 
AS select `event`.`rfid` AS `rfid`,
`event`.`foto` AS `foto`,
`event`.`nome` AS `nome`,
`event`.`turno` AS `turno`,
`event`.`divi` AS `divi`,
`event`.`dept` AS `dept`,
`coutbyid`.`count(``qty``)` AS `count(``qty``)` 
from (`event` join `coutbyid` 
on((`event`.`rfid` = `coutbyid`.`evento`))) 
order by `event`.`nome`;


