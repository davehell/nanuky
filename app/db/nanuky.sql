-- Adminer 4.1.0 SQLite 3 dump

DROP TABLE IF EXISTS "kupci";
CREATE TABLE "kupci" (
  "jmeno" text NOT NULL,
  "dluh" integer NOT NULL DEFAULT '0',
  "zaplaceno" integer NOT NULL DEFAULT '0',
  PRIMARY KEY ("jmeno")
);

INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('dhe',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('jbo',	10,	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('tmo',	11,	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('jsv',	'0',	'0');

DROP TABLE IF EXISTS "nanuky";
CREATE TABLE "nanuky" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "nazev" text NOT NULL,
  "ean" text NOT NULL,
  "baleni" integer NOT NULL DEFAULT '1'
);

INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (1,	'Mrož jahoda - bílá čokoláda',	'1',	12);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (2,	'Mrož jahoda - černá čokoláda',	'2',	12);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (3,	'Mrož jahoda - kelímek',	'3',	6);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (4,	'Ruská zmrzlina',	'4',	10);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (5,	'Pegas - vanilka',	'5',	9);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (6,	'Míša',	'6',	16);

DROP TABLE IF EXISTS "sklad";
CREATE TABLE "sklad" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "nanuky_id" integer NOT NULL,
  "kupec" text NULL,
  "cena_nakup" real NOT NULL,
  "cena_prodej" integer NOT NULL,
  FOREIGN KEY ("nanuky_id") REFERENCES "nanuky" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("kupec") REFERENCES "kupci" ("jmeno") ON DELETE NO ACTION ON UPDATE NO ACTION
);

INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (1,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (2,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (3,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (4,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (5,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (6,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (7,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (8,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (9,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (10,	4,	NULL,	'10.400000000000000355',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (11,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (12,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (13,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (14,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (15,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (16,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (17,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (18,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (19,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (20,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (21,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (22,	3,	NULL,	'14.5',	15);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (23,	1,	'tmo',	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (24,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (25,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (26,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (27,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (28,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (29,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (30,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (31,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (32,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (33,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (34,	1,	NULL,	'10.300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (35,	5,	'jbo',	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (36,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (37,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (38,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (39,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (40,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (41,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (42,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (43,	5,	NULL,	'9.6999999999999992895',	10);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (44,	2,	NULL,	'8.8300000000000000711',	11);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (45,	6,	NULL,	'11.5',	12);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (46,	6,	NULL,	'11.5',	12);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (47,	6,	NULL,	'11.5',	12);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (48,	6,	NULL,	'11.5',	12);
INSERT INTO "sklad" ("id", "nanuky_id", "kupec", "cena_nakup", "cena_prodej") VALUES (49,	6,	NULL,	'11.5',	12);

DROP TABLE IF EXISTS "sqlite_sequence";
CREATE TABLE sqlite_sequence(name,seq);

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('nanuky',	'6');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('sklad',	'49');

DROP VIEW IF EXISTS "volne_nanuky";
CREATE TABLE "volne_nanuky" ("id" integer, "nanuky_id" integer, "nazev" text, "cena" integer);


DROP TABLE IF EXISTS "volne_nanuky";
CREATE VIEW "volne_nanuky" AS
SELECT sklad.id as id, nanuky.id as nanuky_id, nanuky.nazev , cena_prodej as cena
FROM nanuky, sklad
WHERE sklad.nanuky_id = nanuky.id
AND sklad.kupec IS NULL
AND sklad.cena_prodej > 0;

-- 
