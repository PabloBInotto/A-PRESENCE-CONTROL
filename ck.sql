*********************************************
*** Cria uma base de dados antes no mysql ***
*********************************************

CREATE TABLE IF NOT EXISTS `ck` (
`ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`evento` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`qty` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
