create sequence vatrate_idvatrate_seq
    as integer;

alter sequence vatrate_idvatrate_seq owner to root;

create table addresses
(
    idaddress   serial
        constraint addresses_pk
            primary key,
    city        varchar(255) not null,
    street      varchar(255) not null,
    homenumber  varchar(50)  not null,
    localnumber varchar(50),
    zipcode     varchar(6)   not null
);

alter table addresses
    owner to root;

create table roles
(
    idrole      serial
        constraint roles_pk
            primary key,
    name        varchar(255) not null,
    description varchar(255)
);

alter table roles
    owner to root;

create table users
(
    iduser   serial
        constraint users_pk
            primary key,
    name     varchar(255)         not null,
    surname  varchar(255)         not null,
    login    varchar(255)         not null,
    password varchar(255)         not null,
    enabled  boolean default true not null,
    idrole   integer              not null
        constraint users_roles_idrole_fk
            references roles
            on update cascade on delete restrict
);

alter table users
    owner to root;

create table contractors
(
    idcontractor serial
        constraint contractors_pk
            primary key,
    companyname  varchar(255) not null,
    pesel        varchar(11),
    idaddress    integer
        constraint contractors_addresses_idaddress_fk
            references addresses,
    iduser       integer
        constraint contractors_users_iduser_fk
            references users
            on update cascade on delete set null,
    nip          varchar(10)
);

alter table contractors
    owner to root;

create table documentdefinitions
(
    iddocumentdefinition serial
        constraint documentdefinitions_pk
            primary key,
    name                 varchar(255) not null,
    symbol               varchar(10)  not null,
    direction            integer,
    type                 integer,
    description          varchar(255)
);

alter table documentdefinitions
    owner to root;

create table vatrates
(
    idvatrate integer          default nextval('trader.vatrate_idvatrate_seq'::regclass) not null
        constraint vatrate_pk
            primary key,
    percent   double precision default 0                                                 not null
);

alter table vatrates
    owner to root;

alter sequence vatrate_idvatrate_seq owned by vatrates.idvatrate;

create table stockstates
(
    idstockstate serial
        constraint stockstates_pk
            primary key,
    quantity     double precision default 0 not null
);

alter table stockstates
    owner to root;

create table units
(
    idunit serial
        constraint units_pk
            primary key,
    symbol varchar(20) not null,
    name   varchar(255)
);

alter table units
    owner to root;

create table commodities
(
    idcommodity serial
        constraint commodities_pk
            primary key,
    symbol      varchar(20)  not null,
    name        varchar(255) not null,
    description varchar(255),
    idunit      integer
        constraint commodities_units_idunit_fk
            references units
            on update cascade on delete restrict,
    idvatrate   integer
        constraint commodities_vatrate_idvatrate_fk
            references vatrates
            on update cascade on delete restrict
);

alter table commodities
    owner to root;

create table warehouses
(
    idwarehouse serial
        constraint warehouses_pk
            primary key,
    symbol      varchar(20)  not null,
    name        varchar(255) not null,
    description varchar(255),
    idaddress   integer
        constraint warehouses_addresses_idaddress_fk
            references addresses
            on update set null on delete restrict
);

alter table warehouses
    owner to root;

create table currencies
(
    idcurrency serial
        constraint currencies_pk
            primary key,
    symbol     varchar(3)   not null,
    name       varchar(255) not null
);

alter table currencies
    owner to root;

create table documents
(
    iddocument           serial
        constraint documents_pk
            primary key,
    date                 date default now() not null,
    number               varchar(255)       not null,
    state                integer,
    description          varchar(255),
    iddocumentdefinition integer
        constraint documents_documentdefinitions_iddocumentdefinition_fk
            references documentdefinitions
            on update cascade on delete restrict,
    idcontractor         integer
        constraint documents_contractors_idcontractor_fk
            references contractors
            on update cascade on delete restrict,
    idwarehouse          integer
        constraint documents_warehouses_idwarehouse_fk
            references warehouses
            on update cascade on delete restrict,
    idcurrency           integer
        constraint documents_currencies_idcurrency_fk
            references currencies
            on update cascade on delete restrict
);

alter table documents
    owner to root;

create table documentpositions
(
    iddocumentposition serial
        constraint documentpositions_pk
            primary key,
    quantity           double precision default 0 not null,
    price              numeric          default 0 not null,
    iddocument         integer
        constraint documentpositions_documents_iddocument_fk
            references documents
            on update cascade on delete restrict,
    idcommodity        integer
        constraint documentpositions_commodities_idcommodity_fk
            references commodities
            on update cascade on delete restrict,
    idvatrate          integer
        constraint documentpositions_vatrate_idvatrate_fk
            references vatrates
            on update cascade on delete restrict
);

alter table documentpositions
    owner to root;

create table exchanges
(
    idexchange        serial
        constraint exchanges_pk
            primary key,
    dateofpublication date                       not null,
    announcementdate  date                       not null,
    tablenumber       integer                    not null,
    factor            double precision default 0 not null,
    rate              double precision default 0,
    idcurrency        integer
        constraint exchanges_currencies_idcurrency_fk
            references currencies
            on update cascade on delete restrict
);

alter table exchanges
    owner to root;

