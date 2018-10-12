

--
-- Name: bitacora; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bitacora (
    id integer NOT NULL,
    fecha date NOT NULL DEFAULT current_date,
    descripcion text NOT NULL,
    producto character varying(45) NULL,
    PRIMARY KEY (id)
);


ALTER TABLE public.bitacora OWNER TO postgres;

--
-- Name: bitacora_idbitacora_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bitacora_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bitacora_id_seq OWNER TO postgres;

--
-- Name: categoria_p; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_p (
    id integer NOT NULL,
    nombre character varying(45) NULL,
    estado smallint  NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
    );


ALTER TABLE public.categoria_p OWNER TO postgres;

--
-- Name: categoria_p_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_p_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_p_id_seq OWNER TO postgres;



--
-- Name: tipo_r; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_r (
    id integer NOT NULL,
    nombre character varying(45) NULL,
    estado smallint  NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);


ALTER TABLE public.tipo_r OWNER TO postgres;

--
-- Name: tipo_r_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_r_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_r_id_seq OWNER TO postgres;




--
-- Name: producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto (
    id integer NOT NULL,
    nombre character varying(45) NULL,
    precio numeric(7,2) NOT NULL,
    cantidad_actual int NULL,
    estado smallint  NOT NULL DEFAULT 0,
    observaciones TEXT NULL,
    category_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categoria_p (id),
    CONSTRAINT precio_check CHECK ((precio > 0))
);

ALTER TABLE public.producto OWNER TO postgres;

--
-- Name: producto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.producto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.producto_id_seq OWNER TO postgres;




--
-- Name: registro; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registro (
    id integer NOT NULL,
    cantidad int NOT NULL,
    fecha DATE NOT NULL DEFAULT current_date,
    estado smallint  NOT NULL DEFAULT 0,
    observaciones TEXT NULL,
    producto_id int NOT NULL,
    tipo_r_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (producto_id) REFERENCES producto (id),
    FOREIGN KEY (tipo_r_id) REFERENCES tipo_r (id),
    CONSTRAINT cantidad_check CHECK ((cantidad > 0))
);


ALTER TABLE public.registro OWNER TO postgres;

--
-- Name: producto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.registro_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.registro_id_seq OWNER TO postgres;


