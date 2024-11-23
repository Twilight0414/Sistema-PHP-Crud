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
  `nropedido` varchar(50) NOT NULL,   -- Número do pedido (como string, para permitir letras e números)
  `usuario` int(11) NOT NULL,         -- ID do usuário, assumindo que seja uma chave estrangeira
  `idproduto` int(11) NOT NULL,       -- ID do produto, assumindo que seja uma chave estrangeira
  `quantidade` int(11) NOT NULL,      -- Quantidade comprada
  `valorUnitario` decimal(10,2) NOT NULL,  -- Valor unitário do produto na compra
  `dataCompra` datetime NOT NULL,     -- Data e hora da compra
  `datapagamento` datetime DEFAULT NULL, -- Data e hora do pagamento, pode ser NULL se ainda não pago
  PRIMARY KEY(`id`),
  FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,  -- Chave estrangeira para a tabela de usuários
  FOREIGN KEY (`idproduto`) REFERENCES `produtos`(`id`) ON DELETE CASCADE  -- Chave estrangeira para a tabela de produtos
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



