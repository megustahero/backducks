-- Adminer 4.8.1 PostgreSQL 15.3 (Debian 15.3-1.pgdg120+1) dump

\connect "backducks";

CREATE SEQUENCE detour_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."detour" (
    "id" integer DEFAULT nextval('detour_id_seq') NOT NULL,
    "parcel_number" character varying(14) NOT NULL,
    "type" integer NOT NULL,
    "delivery_day" date NOT NULL,
    "insert_date" timestamp NOT NULL,
    CONSTRAINT "detour_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2023-09-21 14:18:25.762885+00
