--
-- PostgreSQL database dump
--


-- Dumped from database version 13.23
-- Dumped by pg_dump version 13.23

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: administrasi_magang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.administrasi_magang (
    admin_id integer NOT NULL,
    mahasiswa_id integer NOT NULL,
    dosen_pembimbing_id integer NOT NULL,
    nama_mitra character varying(255) NOT NULL,
    wilayah_magang character varying(100) NOT NULL,
    jenis_magang character varying(50) NOT NULL,
    periode integer NOT NULL,
    surat_pengantar text,
    surat_penerimaan text
);


ALTER TABLE public.administrasi_magang OWNER TO postgres;

--
-- Name: administrasi_magang_admin_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.administrasi_magang_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.administrasi_magang_admin_id_seq OWNER TO postgres;

--
-- Name: administrasi_magang_admin_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.administrasi_magang_admin_id_seq OWNED BY public.administrasi_magang.admin_id;


--
-- Name: dashboard_mitra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dashboard_mitra (
    mitra_id integer NOT NULL,
    nama_mitra character varying(255) NOT NULL,
    jenis_mitra character varying(100) NOT NULL,
    tahun integer NOT NULL,
    created_by integer NOT NULL
);


ALTER TABLE public.dashboard_mitra OWNER TO postgres;

--
-- Name: dashboard_mitra_mitra_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dashboard_mitra_mitra_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dashboard_mitra_mitra_id_seq OWNER TO postgres;

--
-- Name: dashboard_mitra_mitra_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dashboard_mitra_mitra_id_seq OWNED BY public.dashboard_mitra.mitra_id;


--
-- Name: dashboard_sebaran_jenis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dashboard_sebaran_jenis (
    jenis_id integer NOT NULL,
    jenis_magang character varying(50) NOT NULL,
    jumlah_mahasiswa integer NOT NULL,
    periode integer NOT NULL,
    created_by integer NOT NULL
);


ALTER TABLE public.dashboard_sebaran_jenis OWNER TO postgres;

--
-- Name: dashboard_sebaran_jenis_jenis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dashboard_sebaran_jenis_jenis_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dashboard_sebaran_jenis_jenis_id_seq OWNER TO postgres;

--
-- Name: dashboard_sebaran_jenis_jenis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dashboard_sebaran_jenis_jenis_id_seq OWNED BY public.dashboard_sebaran_jenis.jenis_id;


--
-- Name: dashboard_sebaran_wilayah; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dashboard_sebaran_wilayah (
    wilayah_id integer NOT NULL,
    wilayah character varying(100) NOT NULL,
    jumlah_mahasiswa integer NOT NULL,
    periode integer NOT NULL,
    created_by integer NOT NULL
);


ALTER TABLE public.dashboard_sebaran_wilayah OWNER TO postgres;

--
-- Name: dashboard_sebaran_wilayah_wilayah_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dashboard_sebaran_wilayah_wilayah_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dashboard_sebaran_wilayah_wilayah_id_seq OWNER TO postgres;

--
-- Name: dashboard_sebaran_wilayah_wilayah_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dashboard_sebaran_wilayah_wilayah_id_seq OWNED BY public.dashboard_sebaran_wilayah.wilayah_id;


--
-- Name: desiminasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.desiminasi (
    desiminasi_id integer NOT NULL,
    mahasiswa_id integer,
    proposal_id integer,
    laporan_id integer,
    penguji_id integer,
    status_pengajuan character varying(20) DEFAULT 'menunggu'::character varying,
    tanggal_pengajuan timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    konfirmasi_penguji character varying(20) DEFAULT 'menunggu'::character varying,
    tanggal_konfirmasi timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT desiminasi_konfirmasi_penguji_check CHECK (((konfirmasi_penguji)::text = ANY ((ARRAY['menunggu'::character varying, 'bersedia'::character varying, 'tidak_bersedia'::character varying])::text[]))),
    CONSTRAINT desiminasi_status_pengajuan_check CHECK (((status_pengajuan)::text = ANY ((ARRAY['menunggu'::character varying, 'diterima'::character varying, 'ditolak'::character varying])::text[])))
);


ALTER TABLE public.desiminasi OWNER TO postgres;

--
-- Name: desiminasi_desiminasi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.desiminasi_desiminasi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.desiminasi_desiminasi_id_seq OWNER TO postgres;

--
-- Name: desiminasi_desiminasi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.desiminasi_desiminasi_id_seq OWNED BY public.desiminasi.desiminasi_id;


--
-- Name: dosen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dosen (
    dosen_id integer NOT NULL,
    user_id integer,
    nidn character varying(20),
    nama_dosen character varying(100) NOT NULL,
    email character varying(100),
    no_hp character varying(20),
    bidang_keahlian character varying(100),
    is_dpl boolean DEFAULT false,
    is_penguji boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.dosen OWNER TO postgres;

--
-- Name: dosen_dosen_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dosen_dosen_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dosen_dosen_id_seq OWNER TO postgres;

--
-- Name: dosen_dosen_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dosen_dosen_id_seq OWNED BY public.dosen.dosen_id;


--
-- Name: hasil_desiminasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hasil_desiminasi (
    hasil_id integer NOT NULL,
    desiminasi_id integer,
    mahasiswa_id integer,
    nilai numeric(5,2),
    status_kelulusan character varying(20),
    catatan_revisi text,
    link_laporan_akhir character varying(500),
    status_laporan_akhir character varying(20) DEFAULT 'menunggu'::character varying,
    catatan_penguji text,
    tanggal_acc_laporan_akhir timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT hasil_desiminasi_status_kelulusan_check CHECK (((status_kelulusan)::text = ANY ((ARRAY['lulus'::character varying, 'tidak_lulus'::character varying, 'lulus_bersyarat'::character varying])::text[]))),
    CONSTRAINT hasil_desiminasi_status_laporan_akhir_check CHECK (((status_laporan_akhir)::text = ANY ((ARRAY['menunggu'::character varying, 'disetujui'::character varying, 'revisi'::character varying, 'menunggu_revisi'::character varying])::text[])))
);


ALTER TABLE public.hasil_desiminasi OWNER TO postgres;

--
-- Name: hasil_desiminasi_hasil_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hasil_desiminasi_hasil_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hasil_desiminasi_hasil_id_seq OWNER TO postgres;

--
-- Name: hasil_desiminasi_hasil_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hasil_desiminasi_hasil_id_seq OWNED BY public.hasil_desiminasi.hasil_id;


--
-- Name: jadwal_desiminasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jadwal_desiminasi (
    jadwal_id integer NOT NULL,
    desiminasi_id integer,
    mahasiswa_id integer,
    tanggal_desiminasi date NOT NULL,
    waktu_mulai time without time zone NOT NULL,
    waktu_selesai time without time zone,
    ruangan character varying(50),
    link_online character varying(500),
    status character varying(20) DEFAULT 'terjadwal'::character varying,
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT jadwal_desiminasi_status_check CHECK (((status)::text = ANY ((ARRAY['terjadwal'::character varying, 'selesai'::character varying, 'batal'::character varying, 'menunggu_konfirmasi'::character varying, 'terkonfirmasi'::character varying])::text[])))
);


ALTER TABLE public.jadwal_desiminasi OWNER TO postgres;

--
-- Name: jadwal_desiminasi_jadwal_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jadwal_desiminasi_jadwal_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jadwal_desiminasi_jadwal_id_seq OWNER TO postgres;

--
-- Name: jadwal_desiminasi_jadwal_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jadwal_desiminasi_jadwal_id_seq OWNED BY public.jadwal_desiminasi.jadwal_id;


--
-- Name: laporan_magang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.laporan_magang (
    laporan_id integer NOT NULL,
    mahasiswa_id integer,
    proposal_id integer,
    jenis_laporan character varying(30) NOT NULL,
    link_laporan character varying(500) NOT NULL,
    tanggal_upload timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status_dpl character varying(20) DEFAULT 'menunggu'::character varying,
    catatan_dpl text,
    tanggal_review_dpl timestamp without time zone,
    is_acc_desiminasi boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    link_penilaian_mitra text,
    CONSTRAINT laporan_magang_jenis_laporan_check CHECK (((jenis_laporan)::text = ANY ((ARRAY['draft'::character varying, 'final'::character varying, 'revisi'::character varying])::text[]))),
    CONSTRAINT laporan_magang_status_dpl_check CHECK (((status_dpl)::text = ANY ((ARRAY['menunggu'::character varying, 'disetujui'::character varying, 'revisi'::character varying])::text[])))
);


ALTER TABLE public.laporan_magang OWNER TO postgres;

--
-- Name: laporan_magang_laporan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.laporan_magang_laporan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.laporan_magang_laporan_id_seq OWNER TO postgres;

--
-- Name: laporan_magang_laporan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.laporan_magang_laporan_id_seq OWNED BY public.laporan_magang.laporan_id;


--
-- Name: logbook_magang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.logbook_magang (
    logbook_id integer NOT NULL,
    mahasiswa_id integer,
    proposal_id integer,
    bulan_ke integer NOT NULL,
    link_logbook character varying(500) NOT NULL,
    tanggal_upload timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status_dpl character varying(20) DEFAULT 'belum_review'::character varying,
    catatan_dpl text,
    tanggal_review_dpl timestamp without time zone,
    status_koordinator character varying(20) DEFAULT 'belum_review'::character varying,
    tanggal_review_koordinator timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT logbook_magang_bulan_ke_check CHECK (((bulan_ke >= 1) AND (bulan_ke <= 3))),
    CONSTRAINT logbook_magang_status_dpl_check CHECK (((status_dpl)::text = ANY ((ARRAY['belum_review'::character varying, 'sudah_review'::character varying, 'revisi'::character varying])::text[]))),
    CONSTRAINT logbook_magang_status_koordinator_check CHECK (((status_koordinator)::text = ANY ((ARRAY['belum_review'::character varying, 'sudah_review'::character varying])::text[])))
);


ALTER TABLE public.logbook_magang OWNER TO postgres;

--
-- Name: logbook_magang_logbook_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.logbook_magang_logbook_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.logbook_magang_logbook_id_seq OWNER TO postgres;

--
-- Name: logbook_magang_logbook_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.logbook_magang_logbook_id_seq OWNED BY public.logbook_magang.logbook_id;


--
-- Name: mahasiswa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mahasiswa (
    mahasiswa_id integer NOT NULL,
    user_id integer,
    nim character varying(20) NOT NULL,
    nama_mahasiswa character varying(100) NOT NULL,
    prodi character varying(50) DEFAULT 'Sistem Informasi'::character varying,
    angkatan integer,
    kelas character varying(255),
    no_hp text,
    alamat text,
    dosen_dpl_id integer,
    status_magang character varying(30) DEFAULT 'belum_magang'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.mahasiswa OWNER TO postgres;

--
-- Name: mahasiswa_mahasiswa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mahasiswa_mahasiswa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mahasiswa_mahasiswa_id_seq OWNER TO postgres;

--
-- Name: mahasiswa_mahasiswa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.mahasiswa_mahasiswa_id_seq OWNED BY public.mahasiswa.mahasiswa_id;


--
-- Name: mitra_kerjasama; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mitra_kerjasama (
    mitra_id integer NOT NULL,
    nama_mitra character varying(200) NOT NULL,
    jenis_mitra character varying(50),
    alamat text,
    kota character varying(100),
    provinsi character varying(100),
    website character varying(200),
    email_kontak character varying(100),
    no_telp character varying(20),
    deskripsi text,
    logo character varying(500),
    is_active boolean DEFAULT true,
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.mitra_kerjasama OWNER TO postgres;

--
-- Name: mitra_kerjasama_mitra_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mitra_kerjasama_mitra_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mitra_kerjasama_mitra_id_seq OWNER TO postgres;

--
-- Name: mitra_kerjasama_mitra_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.mitra_kerjasama_mitra_id_seq OWNED BY public.mitra_kerjasama.mitra_id;


--
-- Name: notifikasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifikasi (
    notifikasi_id integer NOT NULL,
    user_id integer,
    judul character varying(200) NOT NULL,
    pesan text,
    link character varying(500),
    is_read boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.notifikasi OWNER TO postgres;

--
-- Name: notifikasi_notifikasi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifikasi_notifikasi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifikasi_notifikasi_id_seq OWNER TO postgres;

--
-- Name: notifikasi_notifikasi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifikasi_notifikasi_id_seq OWNED BY public.notifikasi.notifikasi_id;


--
-- Name: penguji_desiminasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.penguji_desiminasi (
    penguji_id integer NOT NULL,
    desiminasi_id integer NOT NULL,
    dosen_id integer NOT NULL,
    status_acc character varying(50) DEFAULT 'Menunggu'::character varying,
    catatan text
);


ALTER TABLE public.penguji_desiminasi OWNER TO postgres;

--
-- Name: penguji_desiminasi_penguji_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.penguji_desiminasi_penguji_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penguji_desiminasi_penguji_id_seq OWNER TO postgres;

--
-- Name: penguji_desiminasi_penguji_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.penguji_desiminasi_penguji_id_seq OWNED BY public.penguji_desiminasi.penguji_id;


--
-- Name: proposal_magang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.proposal_magang (
    proposal_id integer NOT NULL,
    mahasiswa_id integer,
    judul_proposal character varying(255) NOT NULL,
    instansi_tujuan character varying(200) NOT NULL,
    alamat_instansi text,
    jenis_magang character varying(20) NOT NULL,
    tanggal_mulai date,
    tanggal_selesai date,
    tanggal_pengajuan date DEFAULT CURRENT_DATE,
    link_proposal character varying(500),
    link_surat_penerimaan character varying(500),
    status_koordinator character varying(20) DEFAULT 'menunggu'::character varying,
    catatan_koordinator text,
    tanggal_acc_koordinator timestamp without time zone,
    status_kaprodi character varying(20) DEFAULT 'menunggu'::character varying,
    catatan_kaprodi text,
    tanggal_acc_kaprodi timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status_mitra character varying(20) DEFAULT 'menunggu'::character varying,
    tanggal_balasan_mitra timestamp without time zone,
    butuh_surat_pengantar smallint DEFAULT 1,
    provinsi character varying(100),
    tahun_akademik character varying(20),
    CONSTRAINT proposal_magang_jenis_magang_check CHECK (((jenis_magang)::text = ANY ((ARRAY['reguler'::character varying, 'bumn'::character varying, 'mbkm'::character varying])::text[]))),
    CONSTRAINT proposal_magang_status_kaprodi_check CHECK (((status_kaprodi)::text = ANY ((ARRAY['menunggu'::character varying, 'disetujui'::character varying, 'ditolak'::character varying])::text[]))),
    CONSTRAINT proposal_magang_status_koordinator_check CHECK (((status_koordinator)::text = ANY ((ARRAY['menunggu'::character varying, 'disetujui'::character varying, 'ditolak'::character varying])::text[]))),
    CONSTRAINT proposal_magang_status_mitra_check CHECK (((status_mitra)::text = ANY ((ARRAY['menunggu'::character varying, 'diterima'::character varying, 'ditolak'::character varying])::text[])))
);


ALTER TABLE public.proposal_magang OWNER TO postgres;

--
-- Name: proposal_magang_proposal_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.proposal_magang_proposal_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proposal_magang_proposal_id_seq OWNER TO postgres;

--
-- Name: proposal_magang_proposal_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.proposal_magang_proposal_id_seq OWNED BY public.proposal_magang.proposal_id;


--
-- Name: provinsi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.provinsi (
    provinsi_id integer NOT NULL,
    nama_provinsi character varying(100) NOT NULL,
    kode_provinsi character varying(10),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.provinsi OWNER TO postgres;

--
-- Name: provinsi_provinsi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.provinsi_provinsi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.provinsi_provinsi_id_seq OWNER TO postgres;

--
-- Name: provinsi_provinsi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.provinsi_provinsi_id_seq OWNED BY public.provinsi.provinsi_id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    role_id integer NOT NULL,
    nama_role character varying(50) NOT NULL,
    deskripsi text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_role_id_seq OWNER TO postgres;

--
-- Name: roles_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_role_id_seq OWNED BY public.roles.role_id;


--
-- Name: sebaran_magang; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sebaran_magang (
    sebaran_id integer NOT NULL,
    periode character varying(20) NOT NULL,
    tahun_akademik character varying(10),
    semester character varying(10),
    wilayah character varying(100) NOT NULL,
    provinsi character varying(100),
    jenis_magang character varying(20) NOT NULL,
    jumlah_mahasiswa integer DEFAULT 0,
    nama_instansi character varying(200),
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT sebaran_magang_jenis_magang_check CHECK (((jenis_magang)::text = ANY ((ARRAY['reguler'::character varying, 'bumn'::character varying, 'mbkm'::character varying])::text[])))
);


ALTER TABLE public.sebaran_magang OWNER TO postgres;

--
-- Name: sebaran_magang_sebaran_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sebaran_magang_sebaran_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sebaran_magang_sebaran_id_seq OWNER TO postgres;

--
-- Name: sebaran_magang_sebaran_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sebaran_magang_sebaran_id_seq OWNED BY public.sebaran_magang.sebaran_id;


--
-- Name: surat_pengantar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_pengantar (
    surat_id integer NOT NULL,
    proposal_id integer,
    mahasiswa_id integer,
    nomor_surat character varying(50),
    tanggal_surat date DEFAULT CURRENT_DATE,
    perihal character varying(200),
    tujuan_instansi character varying(200),
    file_surat character varying(500),
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.surat_pengantar OWNER TO postgres;

--
-- Name: surat_pengantar_surat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_pengantar_surat_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.surat_pengantar_surat_id_seq OWNER TO postgres;

--
-- Name: surat_pengantar_surat_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_pengantar_surat_id_seq OWNED BY public.surat_pengantar.surat_id;


--
-- Name: user_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_roles (
    id integer NOT NULL,
    user_id integer NOT NULL,
    role_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.user_roles OWNER TO postgres;

--
-- Name: user_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_roles_id_seq OWNER TO postgres;

--
-- Name: user_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_roles_id_seq OWNED BY public.user_roles.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(255) NOT NULL,
    nama_lengkap character varying(100) NOT NULL,
    role_id integer,
    is_active boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    jabatan character varying(20)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_user_id_seq OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- Name: administrasi_magang admin_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.administrasi_magang ALTER COLUMN admin_id SET DEFAULT nextval('public.administrasi_magang_admin_id_seq'::regclass);


--
-- Name: dashboard_mitra mitra_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dashboard_mitra ALTER COLUMN mitra_id SET DEFAULT nextval('public.dashboard_mitra_mitra_id_seq'::regclass);


--
-- Name: dashboard_sebaran_jenis jenis_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dashboard_sebaran_jenis ALTER COLUMN jenis_id SET DEFAULT nextval('public.dashboard_sebaran_jenis_jenis_id_seq'::regclass);


--
-- Name: dashboard_sebaran_wilayah wilayah_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dashboard_sebaran_wilayah ALTER COLUMN wilayah_id SET DEFAULT nextval('public.dashboard_sebaran_wilayah_wilayah_id_seq'::regclass);


--
-- Name: desiminasi desiminasi_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.desiminasi ALTER COLUMN desiminasi_id SET DEFAULT nextval('public.desiminasi_desiminasi_id_seq'::regclass);


--
-- Name: dosen dosen_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen ALTER COLUMN dosen_id SET DEFAULT nextval('public.dosen_dosen_id_seq'::regclass);


--
-- Name: hasil_desiminasi hasil_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hasil_desiminasi ALTER COLUMN hasil_id SET DEFAULT nextval('public.hasil_desiminasi_hasil_id_seq'::regclass);


--
-- Name: jadwal_desiminasi jadwal_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_desiminasi ALTER COLUMN jadwal_id SET DEFAULT nextval('public.jadwal_desiminasi_jadwal_id_seq'::regclass);


--
-- Name: laporan_magang laporan_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.laporan_magang ALTER COLUMN laporan_id SET DEFAULT nextval('public.laporan_magang_laporan_id_seq'::regclass);


--
-- Name: logbook_magang logbook_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logbook_magang ALTER COLUMN logbook_id SET DEFAULT nextval('public.logbook_magang_logbook_id_seq'::regclass);


--
-- Name: mahasiswa mahasiswa_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa ALTER COLUMN mahasiswa_id SET DEFAULT nextval('public.mahasiswa_mahasiswa_id_seq'::regclass);


--
-- Name: mitra_kerjasama mitra_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mitra_kerjasama ALTER COLUMN mitra_id SET DEFAULT nextval('public.mitra_kerjasama_mitra_id_seq'::regclass);


--
-- Name: notifikasi notifikasi_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifikasi ALTER COLUMN notifikasi_id SET DEFAULT nextval('public.notifikasi_notifikasi_id_seq'::regclass);


--
-- Name: penguji_desiminasi penguji_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penguji_desiminasi ALTER COLUMN penguji_id SET DEFAULT nextval('public.penguji_desiminasi_penguji_id_seq'::regclass);


--
-- Name: proposal_magang proposal_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proposal_magang ALTER COLUMN proposal_id SET DEFAULT nextval('public.proposal_magang_proposal_id_seq'::regclass);


--
-- Name: provinsi provinsi_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provinsi ALTER COLUMN provinsi_id SET DEFAULT nextval('public.provinsi_provinsi_id_seq'::regclass);


--
-- Name: roles role_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN role_id SET DEFAULT nextval('public.roles_role_id_seq'::regclass);


--
-- Name: sebaran_magang sebaran_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sebaran_magang ALTER COLUMN sebaran_id SET DEFAULT nextval('public.sebaran_magang_sebaran_id_seq'::regclass);


--
-- Name: surat_pengantar surat_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar ALTER COLUMN surat_id SET DEFAULT nextval('public.surat_pengantar_surat_id_seq'::regclass);


--
-- Name: user_roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_roles ALTER COLUMN id SET DEFAULT nextval('public.user_roles_id_seq'::regclass);


--
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- Data for Name: administrasi_magang; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: dashboard_mitra; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: dashboard_sebaran_jenis; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: dashboard_sebaran_wilayah; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: desiminasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.desiminasi VALUES (19, 49, 42, 21, 5, 'diterima', '2026-06-27 22:25:58.939772', 'bersedia', '2026-06-27 15:27:09', '2026-06-27 22:25:58.939772', '2026-06-27 15:27:09');
INSERT INTO public.desiminasi VALUES (20, 50, 43, 22, 5, 'diterima', '2026-06-27 22:49:51.61945', 'bersedia', '2026-06-27 16:25:17', '2026-06-27 22:49:51.61945', '2026-06-27 16:25:17');


--
-- Data for Name: dosen; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.dosen VALUES (6, 11, NULL, 'Dosen Satu', NULL, NULL, NULL, true, true, '2026-03-28 20:51:25.766957', '2026-03-28 20:51:25.766957');
INSERT INTO public.dosen VALUES (7, 12, NULL, 'Dosen Dua', NULL, NULL, NULL, true, true, '2026-03-28 20:51:25.766957', '2026-03-28 20:51:25.766957');
INSERT INTO public.dosen VALUES (3, 1, NULL, 'Kaprodi', NULL, NULL, NULL, true, true, '2026-03-28 20:51:09.849304', '2026-03-28 20:51:09.849304');
INSERT INTO public.dosen VALUES (5, 3, NULL, 'Sekretaris Prodi', NULL, NULL, NULL, true, true, '2026-03-28 20:51:09.849304', '2026-03-28 20:51:09.849304');
INSERT INTO public.dosen VALUES (4, 2, NULL, 'Koordinator Magang', NULL, NULL, NULL, true, true, '2026-03-28 20:51:09.849304', '2026-03-28 20:51:09.849304');
INSERT INTO public.dosen VALUES (8, 60, '10003', 'Dosen Tiga', NULL, NULL, NULL, false, true, '2026-06-28 02:43:00.344794', '2026-06-28 02:43:00.344794');
INSERT INTO public.dosen VALUES (9, 61, '10004', 'Dosen Empat', NULL, NULL, NULL, false, true, '2026-06-28 02:43:00.344794', '2026-06-28 02:43:00.344794');
INSERT INTO public.dosen VALUES (10, 62, '10005', 'Dosen Lima', NULL, NULL, NULL, false, true, '2026-06-28 02:43:00.344794', '2026-06-28 02:43:00.344794');


--
-- Data for Name: hasil_desiminasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.hasil_desiminasi VALUES (14, 19, 49, 5.00, 'lulus', '', 'https://drive.google.com/file/d/1wXaMkAXO2vc74vOrzvMqOrk5LzKW_UfR/view?usp=drive_link', 'disetujui', 'masih ada yang kurang
', '2026-06-27 16:31:17', '2026-06-27 22:26:40.613396', '2026-06-27 16:31:17');
INSERT INTO public.hasil_desiminasi VALUES (15, 20, 50, 5.00, 'lulus', '', 'https://drive.google.com/file/d/1wXaMkAXO2vc74vOrzvMqOrk5LzKW_UfR/view?usp=drive_link', 'disetujui', NULL, '2026-06-27 16:35:47', '2026-06-27 22:52:09.569887', '2026-06-27 16:35:47');


--
-- Data for Name: jadwal_desiminasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.jadwal_desiminasi VALUES (14, 19, 49, '2026-06-30', '02:30:00', '23:27:00', 'mam 678', '', 'selesai', NULL, '2026-06-27 15:26:40', '2026-06-27 16:26:43');
INSERT INTO public.jadwal_desiminasi VALUES (15, 20, 50, '2026-06-28', '22:51:00', '01:56:00', 'mam 678', '', 'selesai', NULL, '2026-06-27 15:52:09', '2026-06-27 16:26:53');


--
-- Data for Name: laporan_magang; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.laporan_magang VALUES (21, 49, 42, 'draft', 'https://drive.google.com/file/d/1_mz7nPPTxeUr9cLFlUGDcBKqAQzv6yve/view?usp=sharing', '2026-06-27 22:25:12.962964', 'disetujui', '', '2026-06-27 15:25:37', true, '2026-06-27 22:25:12.962964', '2026-06-27 15:25:37', '');
INSERT INTO public.laporan_magang VALUES (22, 50, 43, 'draft', 'https://drive.google.com/file/d/1_mz7nPPTxeUr9cLFlUGDcBKqAQzv6yve/view?usp=sharing', '2026-06-27 22:44:21.885598', 'disetujui', '', '2026-06-27 15:49:27', true, '2026-06-27 22:44:21.885598', '2026-06-27 15:49:27', '');


--
-- Data for Name: logbook_magang; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.logbook_magang VALUES (98, 50, 43, 3, 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', '2026-06-27 22:42:31.049808', 'sudah_review', '', '2026-06-27 15:42:54', 'belum_review', NULL, '2026-06-27 22:42:31.049808', '2026-06-27 15:42:54');
INSERT INTO public.logbook_magang VALUES (97, 50, 43, 2, 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', '2026-06-27 22:42:26.659442', 'sudah_review', '', '2026-06-27 15:42:57', 'belum_review', NULL, '2026-06-27 22:42:26.659442', '2026-06-27 15:42:57');
INSERT INTO public.logbook_magang VALUES (96, 50, 43, 1, 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', '2026-06-27 22:42:21.493585', 'sudah_review', '', '2026-06-27 15:43:00', 'belum_review', NULL, '2026-06-27 22:42:21.493585', '2026-06-27 15:43:00');
INSERT INTO public.logbook_magang VALUES (95, 49, 42, 3, 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', '2026-06-27 22:23:59.96498', 'sudah_review', '', '2026-06-27 15:24:42', 'belum_review', NULL, '2026-06-27 22:23:59.96498', '2026-06-27 15:24:42');
INSERT INTO public.logbook_magang VALUES (94, 49, 42, 2, 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', '2026-06-27 22:23:55.661536', 'sudah_review', '', '2026-06-27 15:24:45', 'belum_review', NULL, '2026-06-27 22:23:55.661536', '2026-06-27 15:24:45');
INSERT INTO public.logbook_magang VALUES (93, 49, 42, 1, 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', '2026-06-27 22:23:51.411806', 'sudah_review', '', '2026-06-27 15:24:50', 'belum_review', NULL, '2026-06-27 22:23:51.411806', '2026-06-27 15:24:50');


--
-- Data for Name: mahasiswa; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.mahasiswa VALUES (49, 57, '111111', 'HABIB', 'Sistem Informasi', 2022, 'WESCLIC', 'YYYYY', NULL, 4, 'selesai_magang', '2026-06-27 15:14:29', '2026-06-27 16:31:33');
INSERT INTO public.mahasiswa VALUES (50, 58, '223144', 'FUJI HANDARU', 'Sistem Informasi', 2022, 'BUMN', 'wawa', NULL, 3, 'selesai_magang', '2026-06-27 15:38:49', '2026-06-27 16:35:54');


--
-- Data for Name: mitra_kerjasama; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.mitra_kerjasama VALUES (1, 'PT Telekomunikasi Indonesia', 'BUMN', NULL, 'Bandung', 'Jawa Barat', NULL, NULL, NULL, 'Telkom Indonesia', NULL, true, NULL, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271');
INSERT INTO public.mitra_kerjasama VALUES (2, 'PT Bank Rakyat Indonesia', 'BUMN', NULL, 'Jakarta', 'DKI Jakarta', NULL, NULL, NULL, 'BRI', NULL, true, NULL, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271');
INSERT INTO public.mitra_kerjasama VALUES (3, 'Tokopedia', 'Startup', NULL, 'Jakarta', 'DKI Jakarta', NULL, NULL, NULL, 'E-commerce', NULL, true, NULL, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271');
INSERT INTO public.mitra_kerjasama VALUES (4, 'Gojek', 'Startup', NULL, 'Jakarta', 'DKI Jakarta', NULL, NULL, NULL, 'Super App', NULL, true, NULL, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271');
INSERT INTO public.mitra_kerjasama VALUES (5, 'Dinas Kominfo Malang', 'Instansi Pemerintah', NULL, 'Malang', 'Jawa Timur', NULL, NULL, NULL, 'Dinas Komunikasi dan Informatika', NULL, true, NULL, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271');
INSERT INTO public.mitra_kerjasama VALUES (6, 'WESCLIC', 'Startup', 'Gg. Merdeka, Pakuncen, Wirobrajan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55253
No. 19', 'Yogyakarta City', 'Daerah Istimewa Yogyakarta — Special Region of Yogyakarta', '', '', '', '', NULL, true, 3, '2026-06-25 22:15:23.599302', '2026-06-25 22:15:23.599302');


--
-- Data for Name: notifikasi; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: penguji_desiminasi; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: proposal_magang; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.proposal_magang VALUES (42, 49, 'WEBDEV', 'WESCLIC', 'YYYYY', 'reguler', NULL, NULL, '2026-06-27', 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view', 'disetujui', NULL, '2026-06-27 15:19:50', 'disetujui', NULL, '2026-06-27 15:20:14', '2026-06-27 22:19:19.940621', '2026-06-27 15:21:47', 'diterima', '2026-06-27 15:21:47', 0, 'DI Yogyakarta', '2025/2026');
INSERT INTO public.proposal_magang VALUES (43, 50, 'COBA', 'BUMN', 'wawa', 'bumn', NULL, NULL, '2026-06-27', 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view?usp=drive_link', 'https://drive.google.com/file/d/1gS0YNUPEoH0o5OaLaCrKIsZDeR4F8oEu/view', 'disetujui', NULL, '2026-06-27 15:41:24', 'disetujui', NULL, '2026-06-27 15:41:33', '2026-06-27 22:39:54.933224', '2026-06-27 15:41:53', 'diterima', '2026-06-27 15:41:53', 0, 'Sumatera Selatan', '2025/2026');


--
-- Data for Name: provinsi; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.provinsi VALUES (1, 'Aceh', 'AC', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (2, 'Sumatera Utara', 'SU', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (3, 'Sumatera Barat', 'SB', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (4, 'Riau', 'RI', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (5, 'Jambi', 'JA', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (6, 'Sumatera Selatan', 'SS', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (7, 'Bengkulu', 'BE', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (8, 'Lampung', 'LA', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (9, 'Kepulauan Bangka Belitung', 'BB', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (10, 'Kepulauan Riau', 'KR', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (11, 'DKI Jakarta', 'JK', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (12, 'Jawa Barat', 'JB', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (13, 'Jawa Tengah', 'JT', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (14, 'DI Yogyakarta', 'YO', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (15, 'Jawa Timur', 'JI', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (16, 'Banten', 'BT', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (17, 'Bali', 'BA', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (18, 'Nusa Tenggara Barat', 'NB', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (19, 'Nusa Tenggara Timur', 'NT', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (20, 'Kalimantan Barat', 'KB', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (21, 'Kalimantan Tengah', 'KH', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (22, 'Kalimantan Selatan', 'KS', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (23, 'Kalimantan Timur', 'KT', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (24, 'Kalimantan Utara', 'KU', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (25, 'Sulawesi Utara', 'SN', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (26, 'Sulawesi Tengah', 'SG', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (27, 'Sulawesi Selatan', 'SL', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (28, 'Sulawesi Tenggara', 'ST', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (29, 'Gorontalo', 'GO', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (30, 'Sulawesi Barat', 'SW', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (31, 'Maluku', 'MA', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (32, 'Maluku Utara', 'MU', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (33, 'Papua Barat', 'PB', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (34, 'Papua', 'PA', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (35, 'Papua Selatan', 'PS', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (36, 'Papua Tengah', 'PT', '2026-06-24 16:57:15.888796');
INSERT INTO public.provinsi VALUES (37, 'Papua Pegunungan', 'PP', '2026-06-24 16:57:15.888796');


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.roles VALUES (4, 'Dosen Pembimbing Lapangan', 'DPL - Review logbook & laporan mahasiswa', '2026-03-28 20:45:46.327271');
INSERT INTO public.roles VALUES (5, 'Mahasiswa', 'Peserta magang', '2026-03-28 20:45:46.327271');
INSERT INTO public.roles VALUES (6, 'Penguji Desiminasi', 'Review & ACC laporan akhir', '2026-03-28 20:45:46.327271');
INSERT INTO public.roles VALUES (1, 'Kaprodi', 'Kaprodi - ACC tahap 2 proposal', '2026-03-28 20:45:46.327271');
INSERT INTO public.roles VALUES (2, 'Koordinator Magang', 'ACC tahap 1 proposal, monitoring logbook', '2026-03-28 20:45:46.327271');
INSERT INTO public.roles VALUES (3, 'Sekretaris Prodi', 'Administrasi magang lengkap', '2026-03-28 20:45:46.327271');


--
-- Data for Name: sebaran_magang; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.sebaran_magang VALUES (12, '2025/2026', '2025/2026', 'ganjil', '-', 'DI Yogyakarta', 'reguler', 0, '', 3, '2026-06-24 23:52:22.070553', '2026-06-24 23:52:22.070553');
INSERT INTO public.sebaran_magang VALUES (13, '2025/2026', '2025/2026', 'ganjil', '-', 'DI Yogyakarta', 'mbkm', 0, '', 3, '2026-06-24 23:53:08.434696', '2026-06-24 23:53:08.434696');
INSERT INTO public.sebaran_magang VALUES (18, '2024/2025', '2024/2025', 'ganjil', '-', 'Sulawesi Barat', 'reguler', 5, '', 3, '2026-06-25 12:25:31.861423', '2026-06-25 12:25:31.861423');
INSERT INTO public.sebaran_magang VALUES (14, '2025/2026', '2025/2026', 'ganjil', '-', 'DI Yogyakarta', 'bumn', 2, '', 3, '2026-06-24 23:53:21.665944', '2026-06-25 05:50:34');
INSERT INTO public.sebaran_magang VALUES (19, '2024/2025', '2024/2025', 'ganjil', '-', 'Sumatera Utara', 'reguler', 10, '', 3, '2026-06-25 12:26:08.59182', '2026-06-25 07:17:24');


--
-- Data for Name: surat_pengantar; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: user_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.user_roles VALUES (6, 3, 3, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (7, 3, 4, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (8, 3, 6, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (9, 2, 2, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (10, 2, 4, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (11, 2, 6, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (12, 1, 1, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (13, 1, 4, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (14, 1, 6, '2026-03-28 20:51:09.849304');
INSERT INTO public.user_roles VALUES (19, 11, 4, '2026-03-28 20:51:25.766957');
INSERT INTO public.user_roles VALUES (20, 12, 4, '2026-03-28 20:51:25.766957');
INSERT INTO public.user_roles VALUES (21, 11, 6, '2026-03-28 20:51:25.766957');
INSERT INTO public.user_roles VALUES (22, 12, 6, '2026-03-28 20:51:25.766957');
INSERT INTO public.user_roles VALUES (24, 14, 5, '2026-04-29 18:50:47');
INSERT INTO public.user_roles VALUES (67, 57, 5, '2026-06-27 15:14:29');
INSERT INTO public.user_roles VALUES (68, 58, 5, '2026-06-27 15:38:49');
INSERT INTO public.user_roles VALUES (70, 60, 4, '2026-06-28 02:43:00.344794');
INSERT INTO public.user_roles VALUES (71, 61, 4, '2026-06-28 02:43:00.344794');
INSERT INTO public.user_roles VALUES (72, 62, 4, '2026-06-28 02:43:00.344794');
INSERT INTO public.user_roles VALUES (73, 60, 6, '2026-06-28 02:43:00.344794');
INSERT INTO public.user_roles VALUES (74, 61, 6, '2026-06-28 02:43:00.344794');
INSERT INTO public.user_roles VALUES (75, 62, 6, '2026-06-28 02:43:00.344794');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (11, 'dosen1@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Satu', 4, true, '2026-03-28 20:51:25.766957', '2026-03-28 20:51:25.766957', 'dosen');
INSERT INTO public.users VALUES (12, 'dosen2@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Dua', 4, true, '2026-03-28 20:51:25.766957', '2026-03-28 20:51:25.766957', 'dosen');
INSERT INTO public.users VALUES (14, 'mahasiswa6@magang.test', '$2y$10$dWY5tRXYhnTbBBMt93dARuxmTdK30vqcijT/vIztBRU6wol2E.cey', 'yes', 5, true, '2026-04-29 18:50:47', '2026-04-30 01:50:47.558489', NULL);
INSERT INTO public.users VALUES (57, 'mahasiswa1@magang.test', '$2y$10$Z5uMG75Pq54b15V8l0gTpu77Wu3lctmmllLexMJHXJLPAEFu.QNAO', 'HABIB', 5, true, '2026-06-27 15:14:29', '2026-06-27 22:14:29.894826', NULL);
INSERT INTO public.users VALUES (58, 'mahasiswa2@magang.test', '$2y$10$rQB1qF4RrEazjmSO08Rf6.0G3MRpQz4LMFG995uHBXRj7MEwrcuSC', 'FUJI HANDARU', 5, true, '2026-06-27 15:38:49', '2026-06-27 22:38:49.586667', NULL);
INSERT INTO public.users VALUES (1, 'kaprodi@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Kaprodi', 1, true, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271', 'kaprodi');
INSERT INTO public.users VALUES (3, 'sekretaris@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Sekretaris Prodi', 3, true, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271', 'sekretaris');
INSERT INTO public.users VALUES (2, 'koordinator@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Koordinator Magang', 2, true, '2026-03-28 20:45:46.327271', '2026-03-28 20:45:46.327271', 'koordinator');
INSERT INTO public.users VALUES (60, 'dosen3@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Tiga', 4, true, '2026-06-28 02:43:00.344794', '2026-06-28 02:43:00.344794', NULL);
INSERT INTO public.users VALUES (61, 'dosen4@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Empat', 4, true, '2026-06-28 02:43:00.344794', '2026-06-28 02:43:00.344794', NULL);
INSERT INTO public.users VALUES (62, 'dosen5@magang.test', '$2y$10$Z27djEoXNxhoVKHzdy/fg.//idTlRKIj.nL1SQfLmThnsb369DMqK', 'Dosen Lima', 4, true, '2026-06-28 02:43:00.344794', '2026-06-28 02:43:00.344794', NULL);


--
-- Name: administrasi_magang_admin_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.administrasi_magang_admin_id_seq', 1, false);


--
-- Name: dashboard_mitra_mitra_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dashboard_mitra_mitra_id_seq', 1, false);


--
-- Name: dashboard_sebaran_jenis_jenis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dashboard_sebaran_jenis_jenis_id_seq', 1, false);


--
-- Name: dashboard_sebaran_wilayah_wilayah_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dashboard_sebaran_wilayah_wilayah_id_seq', 1, false);


--
-- Name: desiminasi_desiminasi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.desiminasi_desiminasi_id_seq', 20, true);


--
-- Name: dosen_dosen_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dosen_dosen_id_seq', 10, true);


--
-- Name: hasil_desiminasi_hasil_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hasil_desiminasi_hasil_id_seq', 15, true);


--
-- Name: jadwal_desiminasi_jadwal_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jadwal_desiminasi_jadwal_id_seq', 15, true);


--
-- Name: laporan_magang_laporan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.laporan_magang_laporan_id_seq', 22, true);


--
-- Name: logbook_magang_logbook_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.logbook_magang_logbook_id_seq', 98, true);


--
-- Name: mahasiswa_mahasiswa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.mahasiswa_mahasiswa_id_seq', 50, true);


--
-- Name: mitra_kerjasama_mitra_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.mitra_kerjasama_mitra_id_seq', 6, true);


--
-- Name: notifikasi_notifikasi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifikasi_notifikasi_id_seq', 1, false);


--
-- Name: penguji_desiminasi_penguji_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.penguji_desiminasi_penguji_id_seq', 1, false);


--
-- Name: proposal_magang_proposal_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.proposal_magang_proposal_id_seq', 43, true);


--
-- Name: provinsi_provinsi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.provinsi_provinsi_id_seq', 38, true);


--
-- Name: roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_role_id_seq', 1, false);


--
-- Name: sebaran_magang_sebaran_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sebaran_magang_sebaran_id_seq', 20, true);


--
-- Name: surat_pengantar_surat_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_pengantar_surat_id_seq', 48, true);


--
-- Name: user_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_roles_id_seq', 72, true);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_user_id_seq', 62, true);


--
-- Name: administrasi_magang administrasi_magang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.administrasi_magang
    ADD CONSTRAINT administrasi_magang_pkey PRIMARY KEY (admin_id);


--
-- Name: dashboard_mitra dashboard_mitra_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dashboard_mitra
    ADD CONSTRAINT dashboard_mitra_pkey PRIMARY KEY (mitra_id);


--
-- Name: dashboard_sebaran_jenis dashboard_sebaran_jenis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dashboard_sebaran_jenis
    ADD CONSTRAINT dashboard_sebaran_jenis_pkey PRIMARY KEY (jenis_id);


--
-- Name: dashboard_sebaran_wilayah dashboard_sebaran_wilayah_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dashboard_sebaran_wilayah
    ADD CONSTRAINT dashboard_sebaran_wilayah_pkey PRIMARY KEY (wilayah_id);


--
-- Name: desiminasi desiminasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.desiminasi
    ADD CONSTRAINT desiminasi_pkey PRIMARY KEY (desiminasi_id);


--
-- Name: dosen dosen_nidn_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_nidn_key UNIQUE (nidn);


--
-- Name: dosen dosen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_pkey PRIMARY KEY (dosen_id);


--
-- Name: hasil_desiminasi hasil_desiminasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hasil_desiminasi
    ADD CONSTRAINT hasil_desiminasi_pkey PRIMARY KEY (hasil_id);


--
-- Name: jadwal_desiminasi jadwal_desiminasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_desiminasi
    ADD CONSTRAINT jadwal_desiminasi_pkey PRIMARY KEY (jadwal_id);


--
-- Name: laporan_magang laporan_magang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.laporan_magang
    ADD CONSTRAINT laporan_magang_pkey PRIMARY KEY (laporan_id);


--
-- Name: logbook_magang logbook_magang_mahasiswa_id_bulan_ke_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logbook_magang
    ADD CONSTRAINT logbook_magang_mahasiswa_id_bulan_ke_key UNIQUE (mahasiswa_id, bulan_ke);


--
-- Name: logbook_magang logbook_magang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logbook_magang
    ADD CONSTRAINT logbook_magang_pkey PRIMARY KEY (logbook_id);


--
-- Name: mahasiswa mahasiswa_nim_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_nim_key UNIQUE (nim);


--
-- Name: mahasiswa mahasiswa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_pkey PRIMARY KEY (mahasiswa_id);


--
-- Name: mitra_kerjasama mitra_kerjasama_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mitra_kerjasama
    ADD CONSTRAINT mitra_kerjasama_pkey PRIMARY KEY (mitra_id);


--
-- Name: notifikasi notifikasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifikasi
    ADD CONSTRAINT notifikasi_pkey PRIMARY KEY (notifikasi_id);


--
-- Name: penguji_desiminasi penguji_desiminasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.penguji_desiminasi
    ADD CONSTRAINT penguji_desiminasi_pkey PRIMARY KEY (penguji_id);


--
-- Name: proposal_magang proposal_magang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proposal_magang
    ADD CONSTRAINT proposal_magang_pkey PRIMARY KEY (proposal_id);


--
-- Name: provinsi provinsi_nama_provinsi_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provinsi
    ADD CONSTRAINT provinsi_nama_provinsi_key UNIQUE (nama_provinsi);


--
-- Name: provinsi provinsi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provinsi
    ADD CONSTRAINT provinsi_pkey PRIMARY KEY (provinsi_id);


--
-- Name: roles roles_nama_role_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_nama_role_key UNIQUE (nama_role);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (role_id);


--
-- Name: sebaran_magang sebaran_magang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sebaran_magang
    ADD CONSTRAINT sebaran_magang_pkey PRIMARY KEY (sebaran_id);


--
-- Name: surat_pengantar surat_pengantar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_pkey PRIMARY KEY (surat_id);


--
-- Name: user_roles user_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_pkey PRIMARY KEY (id);


--
-- Name: user_roles user_roles_user_id_role_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_user_id_role_id_key UNIQUE (user_id, role_id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: idx_desiminasi_mahasiswa; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_desiminasi_mahasiswa ON public.desiminasi USING btree (mahasiswa_id);


--
-- Name: idx_dosen_user; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_dosen_user ON public.dosen USING btree (user_id);


--
-- Name: idx_jadwal_tanggal; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_jadwal_tanggal ON public.jadwal_desiminasi USING btree (tanggal_desiminasi);


--
-- Name: idx_laporan_mahasiswa; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_laporan_mahasiswa ON public.laporan_magang USING btree (mahasiswa_id);


--
-- Name: idx_logbook_mahasiswa; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_logbook_mahasiswa ON public.logbook_magang USING btree (mahasiswa_id);


--
-- Name: idx_mahasiswa_dpl; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_mahasiswa_dpl ON public.mahasiswa USING btree (dosen_dpl_id);


--
-- Name: idx_mahasiswa_nim; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_mahasiswa_nim ON public.mahasiswa USING btree (nim);


--
-- Name: idx_mahasiswa_user; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_mahasiswa_user ON public.mahasiswa USING btree (user_id);


--
-- Name: idx_notifikasi_user; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_notifikasi_user ON public.notifikasi USING btree (user_id, is_read);


--
-- Name: idx_proposal_mahasiswa; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_proposal_mahasiswa ON public.proposal_magang USING btree (mahasiswa_id);


--
-- Name: idx_proposal_status; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_proposal_status ON public.proposal_magang USING btree (status_koordinator, status_kaprodi);


--
-- Name: idx_sebaran_periode; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_sebaran_periode ON public.sebaran_magang USING btree (periode);


--
-- Name: idx_user_roles_role; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_user_roles_role ON public.user_roles USING btree (role_id);


--
-- Name: idx_user_roles_user; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_user_roles_user ON public.user_roles USING btree (user_id);


--
-- Name: idx_users_email; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_users_email ON public.users USING btree (email);


--
-- Name: idx_users_role; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_users_role ON public.users USING btree (role_id);


--
-- Name: desiminasi desiminasi_laporan_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.desiminasi
    ADD CONSTRAINT desiminasi_laporan_id_fkey FOREIGN KEY (laporan_id) REFERENCES public.laporan_magang(laporan_id);


--
-- Name: desiminasi desiminasi_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.desiminasi
    ADD CONSTRAINT desiminasi_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id) ON DELETE CASCADE;


--
-- Name: desiminasi desiminasi_penguji_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.desiminasi
    ADD CONSTRAINT desiminasi_penguji_id_fkey FOREIGN KEY (penguji_id) REFERENCES public.dosen(dosen_id);


--
-- Name: desiminasi desiminasi_proposal_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.desiminasi
    ADD CONSTRAINT desiminasi_proposal_id_fkey FOREIGN KEY (proposal_id) REFERENCES public.proposal_magang(proposal_id);


--
-- Name: dosen dosen_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- Name: hasil_desiminasi hasil_desiminasi_desiminasi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hasil_desiminasi
    ADD CONSTRAINT hasil_desiminasi_desiminasi_id_fkey FOREIGN KEY (desiminasi_id) REFERENCES public.desiminasi(desiminasi_id) ON DELETE CASCADE;


--
-- Name: hasil_desiminasi hasil_desiminasi_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hasil_desiminasi
    ADD CONSTRAINT hasil_desiminasi_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id);


--
-- Name: jadwal_desiminasi jadwal_desiminasi_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_desiminasi
    ADD CONSTRAINT jadwal_desiminasi_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(user_id);


--
-- Name: jadwal_desiminasi jadwal_desiminasi_desiminasi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_desiminasi
    ADD CONSTRAINT jadwal_desiminasi_desiminasi_id_fkey FOREIGN KEY (desiminasi_id) REFERENCES public.desiminasi(desiminasi_id) ON DELETE CASCADE;


--
-- Name: jadwal_desiminasi jadwal_desiminasi_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_desiminasi
    ADD CONSTRAINT jadwal_desiminasi_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id);


--
-- Name: laporan_magang laporan_magang_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.laporan_magang
    ADD CONSTRAINT laporan_magang_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id) ON DELETE CASCADE;


--
-- Name: laporan_magang laporan_magang_proposal_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.laporan_magang
    ADD CONSTRAINT laporan_magang_proposal_id_fkey FOREIGN KEY (proposal_id) REFERENCES public.proposal_magang(proposal_id);


--
-- Name: logbook_magang logbook_magang_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logbook_magang
    ADD CONSTRAINT logbook_magang_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id) ON DELETE CASCADE;


--
-- Name: logbook_magang logbook_magang_proposal_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logbook_magang
    ADD CONSTRAINT logbook_magang_proposal_id_fkey FOREIGN KEY (proposal_id) REFERENCES public.proposal_magang(proposal_id);


--
-- Name: mahasiswa mahasiswa_dosen_dpl_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_dosen_dpl_id_fkey FOREIGN KEY (dosen_dpl_id) REFERENCES public.dosen(dosen_id);


--
-- Name: mahasiswa mahasiswa_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- Name: mitra_kerjasama mitra_kerjasama_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mitra_kerjasama
    ADD CONSTRAINT mitra_kerjasama_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(user_id);


--
-- Name: notifikasi notifikasi_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifikasi
    ADD CONSTRAINT notifikasi_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- Name: proposal_magang proposal_magang_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proposal_magang
    ADD CONSTRAINT proposal_magang_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id) ON DELETE CASCADE;


--
-- Name: sebaran_magang sebaran_magang_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sebaran_magang
    ADD CONSTRAINT sebaran_magang_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(user_id);


--
-- Name: surat_pengantar surat_pengantar_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(user_id);


--
-- Name: surat_pengantar surat_pengantar_mahasiswa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_mahasiswa_id_fkey FOREIGN KEY (mahasiswa_id) REFERENCES public.mahasiswa(mahasiswa_id);


--
-- Name: surat_pengantar surat_pengantar_proposal_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_proposal_id_fkey FOREIGN KEY (proposal_id) REFERENCES public.proposal_magang(proposal_id) ON DELETE CASCADE;


--
-- Name: user_roles user_roles_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(role_id) ON DELETE CASCADE;


--
-- Name: user_roles user_roles_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- Name: users users_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(role_id);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
GRANT CREATE ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--
