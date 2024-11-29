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
  FOREIGN KEY (`usuario`) REFERENCES `usuarios`(`id`),  
  FOREIGN KEY (`idproduto`) REFERENCES `produtos`(`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,               -- ID do pedido (chave primÃƒÂ¡ria)
    id_usuario INT NOT NULL,                         -- ID do usuÃƒÂ¡rio que fez o pedido (referÃƒÂªncia ao usuÃƒÂ¡rio)
    total DECIMAL(10, 2) NOT NULL,                   -- Total do pedido
    data_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Data e hora do pedido
    status ENUM('pendente', 'pago', 'enviado', 'entregue', 'cancelado') DEFAULT 'pendente',  -- Status do pedido
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)   -- Chave estrangeira para a tabela de usuÃƒÂ¡rios
);

CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,              -- ID do item no pedido (chave primÃƒÂ¡ria)
    pedido_id INT NOT NULL,                         -- ID do pedido (chave estrangeira)
    produto_id INT NOT NULL,                        -- ID do produto (chave estrangeira)
    quantidade INT NOT NULL,                        -- Quantidade do produto no pedido
    subtotal DECIMAL(10, 2) NOT NULL,               -- Subtotal (quantidade * preÃƒÂ§o unitÃƒÂ¡rio)
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,  -- Chave estrangeira para a tabela de pedidos
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT -- Chave estrangeira para a tabela de produtos
);




