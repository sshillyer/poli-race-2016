-- --------------------------------------------------------------------------------------------------
-- Create the database
-- --------------------------------------------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS poli_race_2016

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

-- Political candidates names and parties
CREATE TABLE IF NOT EXISTS candidate(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- primary key, auto increment, NOT NULL
	fname VARCHAR(255) NOT NULL, -- NOT NULL
	lname VARCHAR(255) NOT NULL, -- NOT NULL
	party_id INT(11) NOT NULL, -- NOT NULL; foreign key, references party.id	
	FOREIGN KEY fk_party_id(party_id) REFERENCES party(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- Results (votes, delegates) for a specific candidate at a specific event.
CREATE TABLE IF NOT EXISTS contest_candidate(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	-- TODO: If indeed any given candidate can only have one set of votes for a given contest, then we could
	-- Eliminate the id and replace with a composite key using candidate_id and contest_id
	candidate_id INT(11) NOT NULL,
	contest_id INT(11) NOT NULL, 
	vote_count INT(11) DEFAULT NULL,
	delegate_count INT(11) DEFAULT NULL,
	FOREIGN KEY fk_candidate_id(candidate_id) REFERENCES candidate(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY fk_contest_id(contest_id) REFERENCES contest(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- we could change contest to "contest" and contest_type back to "contest_type" table names??
CREATE TABLE IF NOT EXISTS contest(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- primary key, auto increment, NOT NULL
	contest_date DATE, -- Not sure if we should allow NULL -- probably a good idea in case we want to insert an contest but don't know contest date yet
	state_id INT(11) NOT NULL, -- NOT NULL; foreign key referencing state.id
	party_id INT(11) NOT NULL, -- FK referencing party.id
	contest_type_id INT(11) NOT NULL, -- fk referencing contest_type.id; NOT NULL
	FOREIGN KEY fk_state_id(state_id) REFERENCES state(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY fk_party_id(party_id) REFERENCES party(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY fk_contest_type_id(contest_type_id) REFERENCES contest_type(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
) ENGINE=InnoDB;

-- e.g. democrat, republican, etc.
-- allows us to even put in candidates that are not demo/repub which just aren't associated with any contests
CREATE TABLE IF NOT EXISTS party(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	UNIQUE(name)
) ENGINE=InnoDB;


-- note i changed this from contest_type. we might just kill this table
-- and encode the contest_type as an attribute of contest. each state will have an contest, and the contest will be one type or another. SO we can
-- just have a single-char code like C for caucus (sp?) or whatever
CREATE TABLE IF NOT EXISTS contest_type(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	UNIQUE(name)
) ENGINE=InnoDB;



-- --------------------------------------------------------------------------------------------------
--  Pre-load data from file
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

