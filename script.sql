drop table Plateau;
drop table Carte;
drop table Joueurs;

create table Joueurs (
	nom varchar(10) primary key,
	adresse varchar(10) not null,
	points int default 0,
	elimine int default 0,
	besoin_rafraichir int default 0
);

create table Carte (
	id_carte int primary key, -- 0-17
	valeur int not null, --1-8
	statut varchar(10) not null default 'pioche',
	main_joueur varchar(10) references Joueurs(nom) null,
	pose_joueur varchar(10) references Joueurs(nom) null
);

create table Plateau (
	carte_1 int references Carte(idCarte),
	carte_2 int references Carte(idCarte),
	carte_3 int references Carte(idCarte),
	carte_defausse int references Carte(idCarte)
);

alter table Carte add constraint k_id check (id_carte>=0 and id_carte<18);

insert into Carte (id_carte, valeur) values (0, 8);
insert into Carte (id_carte, valeur) values (1, 7);
insert into Carte (id_carte, valeur) values (2, 6);
insert into Carte (id_carte, valeur) values (3, 5);
insert into Carte (id_carte, valeur) values (4, 5);
insert into Carte (id_carte, valeur) values (5, 4);
insert into Carte (id_carte, valeur) values (6, 4);
insert into Carte (id_carte, valeur) values (7, 3);
insert into Carte (id_carte, valeur) values (8, 3);
insert into Carte (id_carte, valeur) values (9, 2);
insert into Carte (id_carte, valeur) values (10, 2);
insert into Carte (id_carte, valeur) values (11, 1);
insert into Carte (id_carte, valeur) values (12, 1);
insert into Carte (id_carte, valeur) values (13, 1);
insert into Carte (id_carte, valeur) values (14, 1);
insert into Carte (id_carte, valeur) values (15, 1);


