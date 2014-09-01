-- Adminer 4.1.0 SQLite 3 dump

DROP TABLE IF EXISTS "kupci";
CREATE TABLE "kupci" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "jmeno" text NOT NULL,
  "dluh" integer NOT NULL DEFAULT '0'
, "zaplaceno" integer NOT NULL DEFAULT '0');

INSERT INTO "kupci" ("id", "jmeno", "dluh", "zaplaceno") VALUES (1,	'dhe',	'0',	'0');
INSERT INTO "kupci" ("id", "jmeno", "dluh", "zaplaceno") VALUES (2,	'jbo',	'0',	'0');
INSERT INTO "kupci" ("id", "jmeno", "dluh", "zaplaceno") VALUES (3,	'tmo',	'0',	'0');
INSERT INTO "kupci" ("id", "jmeno", "dluh", "zaplaceno") VALUES (4,	'jsv',	'0',	'0');

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
  "kupci_id" integer NULL,
  "cena_nakup" real NOT NULL,
  "cena_prodej" integer NOT NULL,
  FOREIGN KEY ("kupci_id") REFERENCES "kupci" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("nanuky_id") REFERENCES "nanuky" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION
);


DROP TABLE IF EXISTS "sqlite_sequence";
CREATE TABLE sqlite_sequence(name,seq);

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('kupci',	'4');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('nanuky',	'6');
INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('sklad',	'49');

DROP VIEW IF EXISTS "volne_nanuky";
CREATE TABLE "volne_nanuky" ("nanuky_id" integer, "nazev" text, "cena" integer);


DROP TABLE IF EXISTS "volne_nanuky";
CREATE VIEW volne_nanuky AS
SELECT nanuky.id as nanuky_id, nanuky.nazev , cena_prodej as cena
FROM nanuky, sklad
WHERE sklad.nanuky_id = nanuky.id
AND sklad.kupci_id IS NULL
AND sklad.cena_prodej > 0;

-- 
