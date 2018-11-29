#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP TABLE IF EXISTS Possede;
DROP TABLE IF EXISTS Passe;
DROP TABLE IF EXISTS Enregistre;
DROP TABLE IF EXISTS Joue;
DROP TABLE IF EXISTS Propose;
DROP TABLE IF EXISTS Constitue;
DROP TABLE IF EXISTS Commentaire;
DROP TABLE IF EXISTS Date_table;
DROP TABLE IF EXISTS Points;
DROP TABLE IF EXISTS Utilisateur;
DROP TABLE IF EXISTS Parcours;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Utilisateur(
        id_utilisateur     Int NOT NULL AUTO_INCREMENT,
        login              Varchar (50) NOT NULL ,
        mdp                Varchar (50) NOT NULL ,
        nom_utilisateur    Varchar (50) NOT NULL ,
        prenom_utilisateur Varchar (50) NOT NULL ,
        droit_admin        Bool NOT NULL
	,CONSTRAINT Utilisateur_PK PRIMARY KEY (id_utilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Parcours
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Parcours(
        id_parcours          Int NOT NULL AUTO_INCREMENT,
        nom_parcours         Varchar (50) NOT NULL ,
        distance             Double NOT NULL ,
        difficulte           Int NOT NULL ,
        duree                Int NOT NULL ,
        description_parcours Varchar (50) NOT NULL ,
        type_parcours        Varchar (50) NOT NULL
	,CONSTRAINT Parcours_PK PRIMARY KEY (id_parcours)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Point
#------------------------------------------------------------

CREATE TABLE Points(
        id_point         Int NOT NULL AUTO_INCREMENT,
        longitude        Double NOT NULL ,
        latitude         Double NOT NULL ,
        depart           Bool NOT NULL ,
        arrive           Bool NOT NULL ,
        decription_point Varchar (50) NOT NULL
	,CONSTRAINT Point_PK PRIMARY KEY (id_point)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commentaire
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Commentaire(
        id_commentaire Int NOT NULL AUTO_INCREMENT,
        libelle        Varchar (50) NOT NULL ,
        id_utilisateur Int NOT NULL
	,CONSTRAINT Commentaire_PK PRIMARY KEY (id_commentaire)

	,CONSTRAINT Commentaire_Utilisateur_FK FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Date
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Date_table(
        date_enregistre Date NOT NULL
	,CONSTRAINT Date_PK PRIMARY KEY (date_enregistre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Constitue
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Constitue(
        id_parcours Int NOT NULL ,
        id_point    Int NOT NULL ,
        nb_point    Int NOT NULL
	,CONSTRAINT Constitue_PK PRIMARY KEY (id_parcours,id_point)

	,CONSTRAINT Constitue_Parcours_FK FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours)
	,CONSTRAINT Constitue_Point0_FK FOREIGN KEY (id_point) REFERENCES Points(id_point)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Propose
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Propose(
        id_utilisateur Int NOT NULL ,
        id_parcours    Int NOT NULL ,
        date_enregistre      Date NOT NULL
	,CONSTRAINT Propose_PK PRIMARY KEY (id_utilisateur,id_parcours,date_enregistre)

	,CONSTRAINT Propose_Utilisateur_FK FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
	,CONSTRAINT Propose_Parcours0_FK FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours)
	,CONSTRAINT Propose_Date1_FK FOREIGN KEY (date_enregistre) REFERENCES Date_table(date_enregistre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Enregistre
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Enregistre(
        id_parcours    Int NOT NULL ,
        id_utilisateur Int NOT NULL ,
        nb_parcours    Int NOT NULL
	,CONSTRAINT Enregistre_PK PRIMARY KEY (id_parcours,id_utilisateur)

	,CONSTRAINT Enregistre_Parcours_FK FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours)
	,CONSTRAINT Enregistre_Utilisateur0_FK FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Joue
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Joue(
        id_utilisateur Int NOT NULL ,
        id_parcours    Int NOT NULL ,
        date_enregistre           Date NOT NULL ,
        etape          Int NOT NULL
	,CONSTRAINT Joue_PK PRIMARY KEY (id_utilisateur,id_parcours,date_enregistre)

	,CONSTRAINT Joue_Utilisateur_FK FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
	,CONSTRAINT Joue_Parcours0_FK FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours)
	,CONSTRAINT Joue_Date1_FK FOREIGN KEY (date_enregistre) REFERENCES Date_table(date_enregistre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Possede
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Possede(
        id_parcours    Int NOT NULL ,
        id_commentaire Int NOT NULL ,
        date_enregistre           Date NOT NULL
	,CONSTRAINT Possede_PK PRIMARY KEY (id_parcours,id_commentaire,date_enregistre)

	,CONSTRAINT Possede_Parcours_FK FOREIGN KEY (id_parcours) REFERENCES Parcours(id_parcours)
	,CONSTRAINT Possede_Commentaire0_FK FOREIGN KEY (id_commentaire) REFERENCES Commentaire(id_commentaire)
	,CONSTRAINT Possede_Date1_FK FOREIGN KEY (date_enregistre) REFERENCES Date_table(date_enregistre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Passe
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Passe(
        id_utilisateur Int NOT NULL ,
        id_point       Int NOT NULL ,
        date_enregistre DATE NOT NULL
    ,CONSTRAINT Passe_PK PRIMARY KEY (id_utilisateur,id_point,date_enregistre)

	,CONSTRAINT Passe_Utilisateur_FK FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
	,CONSTRAINT Passe_Point0_FK FOREIGN KEY (id_point) REFERENCES Points(id_point)
	,CONSTRAINT Passe_Date1_FK FOREIGN KEY (date_enregistre) REFERENCES Date_table(date_enregistre)
)ENGINE=InnoDB;


