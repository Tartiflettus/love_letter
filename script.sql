drop table Jeu;
drop table Carte;
drop table Joueurs;


create table Joueurs (
	id int primary key auto_increment,
	num_partie int references Jeu(num_partie),
	nom varchar(20) default 'toto',
	adresse varchar(10),
	points int default 0,
	elimine int default 0
);

create table Jeu (
	num_partie int primary key auto_increment,
	manche int not null,
	joueur_actu int references Joueurs(id),
	nb_joueurs int default 0,
	carte_selec int
);



create table Carte (
	id_carte int primary key auto_increment,
	valeur int not null, -- rang de la carte 1-8
	num_partie int not null references Jeu(num_partie),
	statut varchar(10) not null default 'pioche', /*peut prendre valeurs : 
													pioche, defausse, carte(1,2,3),
													main, pose*/
	main_joueur varchar(10) null references Joueurs(id),
	pose_joueur varchar(10) null references Joueurs(id),
	image varchar(100) null
);

alter table Carte add constraint k_id check (id_carte>=0 and id_carte<18);



insert into Jeu (manche) values (0);

