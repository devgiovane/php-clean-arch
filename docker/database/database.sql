USE clean_arch;

SET character_set_client = utf8;
SET character_set_connection = utf8;
SET character_set_results = utf8;
SET collation_connection = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `registrations`
(
    id int auto_increment,
    name varchar(100) not null,
    email varchar(100) not null,
    number char(11) not null,
    birth_date date not null,
    created_at DATETIME not null,
    constraint table_name_pk
        primary key (id)
);

INSERT INTO `registrations` (name, email, number, birth_date, created_at) VALUES ('Giovane Santos', 'giovanesantos1999@gmail.com', '01234567890', '1999-07-02', '2021-10-15');

