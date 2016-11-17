drop table Jeu;
drop table Carte;
drop table Joueurs;

create table Jeu (
	num_partie int primary key auto_increment,
	manche int not null,
	joueur_1 varchar(10) references Joueurs(nom),
	joueur_2 varchar(10) references Joueurs(nom),
	joueur_3 varchar(10) references Joueurs(nom),
	joueur_4 varchar(10) references Joueurs(nom)
);

create table Joueurs (
	id int primary key auto_increment,
	nom varchar(10),
	adresse varchar(10) not null,
	points int default 0,
	elimine int default 0
);

create table Carte (
	id_carte int primary key auto_increment, --id unique 0-15
	valeur int not null, -- rang de la carte 1-8
	num_partie int not null references Jeu(num_partie),
	statut varchar(10) not null default 'pioche', /*peut prendre valeur : 
													pioche, defausse, carte(1,2,3),
													main, pose*/
	main_joueur varchar(10) null references Joueurs(nom),
	pose_joueur varchar(10) null references Joueurs(nom),
	image varchar(100) null
);

alter table Carte add constraint k_id check (id_carte>=0 and id_carte<18);
