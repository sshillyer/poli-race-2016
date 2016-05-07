-- TODO:
--  * Indices where needed


-- --------------------------------------------------------------------------------------------------
--  Create the tables for the database
-- --------------------------------------------------------------------------------------------------

-- See list of states at wikipeida.org, list_of_states_and_territories_of_the_United_States
CREATE TABLE IF NOT EXISTS state (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- PK
	name VARCHAR(255) NOT NULL, 
	abbreviation char(2) NOT NULL,
	UNIQUE(name, abbreviation)
) ENGINE=InnoDB; -- Check syntax on this

-- e.g. democrat, republican, etc.
-- allows us to even put in candidates that are not demo/repub which just aren't associated with any contests
CREATE TABLE IF NOT EXISTS party (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	UNIQUE(name)
) ENGINE=InnoDB;

-- Political candidates names and parties
CREATE TABLE IF NOT EXISTS candidate (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- primary key, auto increment, NOT NULL
	fname VARCHAR(255) NOT NULL, -- NOT NULL
	lname VARCHAR(255) NOT NULL, -- NOT NULL
	party_id INT(11) NOT NULL, -- NOT NULL; foreign key, references party.id	
	FOREIGN KEY fk_party_id(party_id) REFERENCES party(id)
		ON DELETE RESTRICT
) ENGINE=InnoDB;

-- The type of contest that's held for a specific political party in a specific state. e.g. caucus | primary
CREATE TABLE IF NOT EXISTS contest_type (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	UNIQUE(name)
) ENGINE=InnoDB;


-- we could change contest to "contest" and contest_type back to "contest_type" table names??
CREATE TABLE IF NOT EXISTS contest (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	contest_date DATE,
	state_id INT(11) NOT NULL,
	party_id INT(11) NOT NULL,
	contest_type_id INT(11) NOT NULL, 
	FOREIGN KEY fk_state_id(state_id) REFERENCES state(id)
		ON DELETE RESTRICT,
	FOREIGN KEY fk_party_id(party_id) REFERENCES party(id)
		ON DELETE RESTRICT,
	FOREIGN KEY fk_contest_type_id(contest_type_id) REFERENCES contest_type(id)
		ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Results (votes, delegates) for a specific candidate at a specific event.
CREATE TABLE IF NOT EXISTS contest_candidate (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	candidate_id INT(11) NOT NULL,
	contest_id INT(11) NOT NULL, 
	vote_count INT(11) DEFAULT NULL,
	delegate_count INT(11) DEFAULT NULL,
	FOREIGN KEY fk_candidate_id(candidate_id) REFERENCES candidate(id)
		ON DELETE RESTRICT,
	FOREIGN KEY fk_contest_id(contest_id) REFERENCES contest(id)
		ON DELETE RESTRICT,
	UNIQUE(candidate_id, contest_id)
) ENGINE=InnoDB;



-- --------------------------------------------------------------------------------------------------
--  Pre-load data from file
-- NOTE: Only use once we have created the files and stored them in some path (which should be
-- updated)
-- --------------------------------------------------------------------------------------------------

LOAD DATA LOCAL INFILE '/path/states.data' INTO TABLE state
LINES TERMINATED BY '\r\n';

LOAD DATA LOCAL INFILE '/path/party.data' INTO TABLE party
LINES TERMINATED BY '\r\n';

LOAD DATA LOCAL INFILE '/path/contest_type.data' INTO TABLE contest_type
LINES TERMINATED BY '\r\n';

LOAD DATA LOCAL INFILE '/path/candidate.data' INTO TABLE candidate
LINES TERMINATED BY '\r\n';

LOAD DATA LOCAL INFILE '/path/contest.data' INTO TABLE contest
LINES TERMINATED BY '\r\n';

LOAD DATA LOCAL INFILE '/path/contest_candidate.data' INTO TABLE contest_candidate
LINES TERMINATED BY '\r\n';


-- --------------------------------------------------------------------------------------------------
-- Grant access to a web user for use on the site
-- --------------------------------------------------------------------------------------------------

GRANT select, insert, delete, update ON hillyers-db.* TO webuser IDENTIFIED BY `password123`;