-- Adminer 4.1.0 SQLite 3 dump

DROP TABLE IF EXISTS "kupci";
CREATE TABLE "kupci" (
  "jmeno" text NOT NULL,
  "prijmeni" text NULL,
  "dluh" integer NOT NULL DEFAULT '0',
  "zaplaceno" integer NOT NULL DEFAULT '0',
  "datum_platby" text NULL,
  PRIMARY KEY ("jmeno")
);

INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('DHE',	'Hellebrand',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('JBO',	'Bocek',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('TMO',	'Mollnhuber',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('JSV',	'Svoboda',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('AKI',	'Kij',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('ARA',	'Radimák',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('JHB',	'Hrbek',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('JHR',	'Harčarik',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('JLA',	'Laga',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('KPE',	'Pešulová',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('LBU',	'Burdová',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('MHA',	'Hahn',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('MKR',	'Krchňák',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('MMA',	'Maléř',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('MPI',	'Pilch',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('MSA',	'Sabela',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('PVR',	'Vrubel',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('RKO',	'Kroča',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('VMA',	'Machálková',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('VNE',	'Nečas',	0,	0);
INSERT INTO "kupci" ("jmeno", "prijmeni", "dluh", "zaplaceno") VALUES ('JST', 'Števková',  0,  0);

DROP TABLE IF EXISTS "mrazak";
CREATE TABLE "mrazak" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "nanuky_id" integer NOT NULL,
  "kupec" text NULL,
  "cena_nakup" real NOT NULL,
  "cena_prodej" integer NOT NULL,
  "datum_nakupu" text NULL,
  "ip" text NULL,
  FOREIGN KEY ("kupec") REFERENCES "kupci" ("jmeno") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("nanuky_id") REFERENCES "nanuky" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION
);


DROP TABLE IF EXISTS "nanuky";
CREATE TABLE "nanuky" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "nazev" text NOT NULL,
  "baleni" integer NOT NULL DEFAULT '1'
);

INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (1,	'Mrož bílá čokoláda',	12);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (2,	'Mrož tmavá čokoláda',	12);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (3,	'Mrož kelímek',	6);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (4,	'Ruská zmrzlina',	10);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (5,	'Pegas - vanilka',	9);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (6,	'Míša',	16);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (7,	'Mrož dřeň - jahoda',	12);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (8,	'Mrož dřeň - malina',	12);
INSERT INTO "nanuky" ("id", "nazev", "baleni") VALUES (9,	'Pegas - kokos',	9);

DROP TABLE IF EXISTS "sqlite_sequence";
CREATE TABLE sqlite_sequence(name,seq);

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('mrazak',	'125');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('nanuky',	'9');

-- 
