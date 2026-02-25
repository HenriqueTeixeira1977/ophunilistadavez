CREATE DATABASE lista_vez;
USE lista_vez;



CREATE DATABASE lista_vez;
USE lista_vez;

CREATE TABLE vendedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    senha VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE fila (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vendedor_id INT,
    posicao INT,
    FOREIGN KEY (vendedor_id) REFERENCES vendedores(id)
);

CREATE TABLE atendimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vendedor_id INT,
    cliente VARCHAR(100),
    valor DECIMAL(10,2),
    resultado ENUM('Venda','Não comprou','Troca'),
    observacoes TEXT,
    data_atendimento DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vendedor_id) REFERENCES vendedores(id)
);