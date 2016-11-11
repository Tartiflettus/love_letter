drop table Plateau;
drop table Defausse;
drop table Pioche;
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
	id_carte int primary key,
	valeur int not null,
	statut varchar(10) not null default 'pioche',
	main_joueur varchar(10) references Joueurs(nom),
	pose_joueur varchar(10) references Joueurs(nom)
);

create table Pioche (
	id_carte int references Carte(idCarte)
);

create table Defausse (
	id_carte int references Carte(idCarte)
);

create table Plateau (
	carte_1 int references Carte(idCarte),
	carte_2 int references Carte(idCarte),
	carte_3 int references Carte(idCarte),
	carte_defausse int references Carte(idCarte)
);

alter table Carte add constraint k_id check (id_carte>=0 and id_carte<18);