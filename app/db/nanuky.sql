-- Adminer 4.1.0 SQLite 3 dump

DROP TABLE IF EXISTS "kupci";
CREATE TABLE "kupci" (
  "jmeno" text NOT NULL,
  "dluh" integer NOT NULL DEFAULT '0',
  "zaplaceno" integer NOT NULL DEFAULT '0',
  PRIMARY KEY ("jmeno")
);

INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('DHE',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('JBO',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('TMO',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('JSV',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('AKI',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('ARA',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('JHB',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('JHR',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('JLA',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('KPE',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('LBU',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('MHA',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('MKR',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('MMA',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('MPI',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('MSA',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('PVR',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('RKO',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('VMA',	'0',	'0');
INSERT INTO "kupci" ("jmeno", "dluh", "zaplaceno") VALUES ('VNE',	'0',	'0');

DROP TABLE IF EXISTS "mrazak";
CREATE TABLE "mrazak" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "nanuky_id" integer NOT NULL,
  "kupec" text NULL,
  "cena_nakup" real NOT NULL,
  "cena_prodej" integer NOT NULL,
  FOREIGN KEY ("nanuky_id") REFERENCES "nanuky" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  FOREIGN KEY ("kupec") REFERENCES "kupci" ("jmeno") ON DELETE NO ACTION ON UPDATE NO ACTION
);


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
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (7,	'Mrož - dřeň jahoda',	'7',	12);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (8,	'Mrož - dřeň malina',	'8',	12);
INSERT INTO "nanuky" ("id", "nazev", "ean", "baleni") VALUES (9,	'Pegas - kokos',	'9',	9);

DROP TABLE IF EXISTS "sqlite_sequence";
CREATE TABLE sqlite_sequence(name,seq);

INSERT INTO "sqlite_sequence" ("name", "seq") VALUES ('nanuky',	'9');

DROP VIEW IF EXISTS "volne_nanuky";
CREATE TABLE "volne_nanuky" ("id" integer, "nanuky_id" integer, "nazev" text, "cena" integer);


DROP TABLE IF EXISTS "volne_nanuky";
CREATE VIEW "volne_nanuky" AS
SELECT mrazak.id as id, nanuky.id as nanuky_id, nanuky.nazev , cena_prodej as cena
FROM nanuky, mrazak
WHERE mrazak.nanuky_id = nanuky.id
AND mrazak.kupec IS NULL
AND mrazak.cena_prodej > 0;

-- 
