# Sistema-PHP-Crud

#CREATE TABLE `usuarios` (
`id` int(11) NOT NULL auto_increment,
`nome` varchar(80) NOT NULL,
`telefone` varchar(20) NOT NULL,
`email` varchar(80) NOT NULL,
`senha` varchar(80) NOT NULL,
PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

USE tssistemadb;

select * from usuarios;
