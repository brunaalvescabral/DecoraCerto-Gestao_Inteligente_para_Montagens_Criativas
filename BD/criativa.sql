create database criativa;

use criativa;

create table Empreendedor (
	id integer not null auto_increment primary key,
    nome varchar(30),
    contato varchar(255),
    login varchar(255),
    senha varchar(255)
);

create table MetaFinanceira (
	id integer not null auto_increment primary key,
    id_empreendedor int not null,
    descrição varchar(255),
    valormeta float(10, 2),
    valoratual float(10, 2),
    datainicio date,
    datafim date,
    progresso float(5, 2),
    foreign key (id_empreendedor) references empreendedor (id)
);

create table LancamentoFinanceiro (
    id integer auto_increment primary key,
    id_empreendedor int not null,
    tipo enum('Entrada', 'Saida') not null,
    descricao varchar(255),
    valor float(10, 2) not null,
    data_lancamento date not null,
    categoria varchar(100), 
    foreign key (id_empreendedor) references Empreendedor(id)
);

create table Custo (
    id integer auto_increment primary key,
    id_empreendedor int not null,
    tipo_custo enum('Fixo', 'Variavel') not null,
    descricao varchar(255) not null,
    valor float(10, 2) not null,
    periodicidade varchar(50),
    foreign key (id_empreendedor) references Empreendedor(id)
);


create table Investimento (
    id int auto_increment primary key,
    id_empreendedor int not null,
    descricao varchar(255) not null,
    valor float(10, 2) not null,
    data_investimento date not null,
    retorno_esperado varchar(255), 
    foreign key (id_empreendedor) references Empreendedor(id)
);


create table RiscoFinanceiro (
    id int auto_increment primary key,
    id_empreendedor int not null,
    tipo_risco enum('Inadimplencia', 'Devolucao Atrasada', 'Despesa Imprevista') not null,
    descricao varchar(255),
    valor_associado float(10, 2),
    data_ocorrencia date not null,
    resolvido boolean default false,
    foreign key (id_empreendedor) references Empreendedor(id)
);


create table ItemEstoque (
    id int auto_increment primary key,
    id_empreendedor int not null,
    nome_item varchar(255) not null,
    custo_unitario float(10, 2) not null,
    quantidade_estoque int not null,
    unidade_medida varchar(50), 
    foreign key (id_empreendedor) references Empreendedor(id)
);

create table KitMontagem (
    id int auto_increment primary key,
    id_empreendedor int not null,
    nome_kit varchar(255) not null,
    valor_venda float(10, 2) not null,
    margem_lucro_prevista float(5, 2), 
    foreign key (id_empreendedor) references Empreendedor(id)
);


create table Cliente (
    id int auto_increment primary key,
    id_empreendedor int not null,
    nome varchar(255) not null,
    contato varchar(255),
    endereco varchar(255),
    foreign key (id_empreendedor) references Empreendedor(id)
);

create table Pedido (
    id int auto_increment primary key,
    id_empreendedor int not null,
    id_cliente int,
    data_pedido date not null,
    data_entrega date,
    valor_total float(10, 2) not null,
    status_pagamento enum('Pendente', 'Pago', 'Parcialmente Pago') not null,
    observacoes text,
    foreign key (id_empreendedor) references Empreendedor(id),
    foreign key (id_cliente) references Cliente(id)
);

create table Kit_Item (
    id_kit_item int auto_increment primary key,
    id_kit int not null,
    id_item int not null,
    quantidade_necessaria int not null,
    foreign key (id_kit) references KitMontagem(id),
    foreign key (id_item) references ItemEstoque(id)
);

create table Pedido_Kit (
    id int auto_increment primary key,
    id_pedido int not null,
    id_kit int not null,
    quantidade_kit int not null,
    foreign key (id_pedido) references Pedido(id),
    foreign key (id_kit) references KitMontagem(id)
);
