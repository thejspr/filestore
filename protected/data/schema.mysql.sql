DROP TABLE IF EXISTS tbl_user;
CREATE TABLE IF NOT EXISTS tbl_user (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(128) NOT NULL,
    password varchar(128) NOT NULL,
    salt varchar(128) DEFAULT NULL,
    email varchar(128) NOT NULL,
    created int(11) DEFAULT NULL,
    updated int(11) DEFAULT 0,
    last_login int(11) DEFAULT 0,
    login_count int(11) DEFAULT 0,
    failed_login_attempts int(11) DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 COLLATE latin1_general_ci ;


DROP TABLE IF EXISTS tbl_file;
CREATE TABLE IF NOT EXISTS tbl_file (
    id int(11) NOT NULL AUTO_INCREMENT,
    folder_id int(11) NOT NULL,
    owner_id int(11) NOT NULL,
    file_name varchar(128) NOT NULL,
    public tinyint(1) DEFAULT NULL,
    created int(11) DEFAULT NULL,
    last_edit int(11) DEFAULT 0,
    PRIMARY KEY (id),
    KEY own_ind (owner_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 COLLATE latin1_general_ci ;


DROP TABLE IF EXISTS tbl_folder;
CREATE TABLE IF NOT EXISTS tbl_folder (
    id int(11) NOT NULL AUTO_INCREMENT,
    owner_id int(11) NOT NULL,
    folder_name varchar(128) NOT NULL,
    is_root tinyint(1) DEFAULT NULL,
    public tinyint(1) DEFAULT NULL,
    PRIMARY KEY (id),
    KEY own_ind (owner_id)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 COLLATE latin1_general_ci ;


DROP TABLE IF EXISTS tbl_file_shares;
CREATE TABLE IF NOT EXISTS tbl_file_shares (
    id int(11) NOT NULL AUTO_INCREMENT,
    file_id int(11) NOT NULL,
    user_id int(11) NOT NULL,
    PRIMARY KEY (id)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_general_ci ;

DROP TABLE IF EXISTS tbl_folder_shares;