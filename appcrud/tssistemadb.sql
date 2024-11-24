CREATE TABLE `usuarios` (
`id` int(11) NOT NULL auto_increment,
`nome` varchar(80) NOT NULL,
`telefone` varchar(20) NOT NULL,
`email` varchar(80) NOT NULL,
`senha` varchar(80) NOT NULL,
PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

USE tssistemadb
INSERT INTO usuarios (nome, telefone, email, senha) 
VALUES ('Thales', '16999776125', 'thales@teste.com', '123');
select * from produtos

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `descricao` text NOT NULL,
  `marca` varchar(80) NOT NULL,
  `modelo` varchar(80) NOT NULL,
  `valorunitario` decimal(10,0) NOT NULL,
  `categoria` varchar(80) NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nropedido` varchar(50) NOT NULL,   
  `usuario` int(11) NOT NULL,        
  `idproduto` int(11) NOT NULL,       
  `quantidade` int(11) NOT NULL,      
  `valorUnitario` decimal(10,2) NOT NULL,  
  `dataCompra` datetime NOT NULL,    
  `datapagamento` datetime DEFAULT NULL, 
  PRIMARY KEY(`id`),
  FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,  
  FOREIGN KEY (`idproduto`) REFERENCES `produtos`(`id`) ON DELETE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



