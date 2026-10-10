CREATE DATABASE IF NOT EXISTS loja_brinquedos;

USE loja_brinquedos;

DROP TABLE IF EXISTS brinquedos;

CREATE TABLE brinquedos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    faixa_etaria VARCHAR(30) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL
);

INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, estoque) VALUES
('Carrinho de Controle Remoto', 'Veiculos', '5 a 8 anos', 89.90, 10),
('Boneca Maria', 'Bonecas', '3 a 6 anos', 49.50, 15),
('Quebra-cabeca 100 pecas', 'Jogos', '6 a 10 anos', 35.00, 20);