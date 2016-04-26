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
	name VARCHAR(255) NOT NULL
) ENGINE=InnoDB;


-- note i changed this from contest_type. we might just kill this table
-- and encode the contest_type as an attribute of contest. each state will have an contest, and the contest will be one type or another. SO we can
-- just have a single-char code like C for caucus (sp?) or whatever
CREATE TABLE IF NOT EXISTS contest_type(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL
) ENGINE=InnoDB;


-- Insert rows into various tables
-- INSERT INTO tablename VALUES (x, y, z); -- ughhh syntax?? lol

-- Should consider using a file with all the state names and abbreviations like so:
-- OR if using windows with \r\n endlines use the additional line
LOAD DATA LOCAL INFILE '/path/states.data' INTO TABLE state
LINES TERMINATED BY '\r\n';
-- example data would look like this:
-- Oregon OR
-- California CA

INSERT INTO state(name, abbreviation)
	VALUES([inputName], [inputAbbreviation]); -- can comma separate additional rows if the LOAD DATA doesn't work and prepopulate

-- Mass loading of party
LOAD DATA LOCAL INFILE '/path/party.data' INTO TABLE party
LINES TERMINATED BY '\r\n';

-- Query for use on site
INSERT INTO party(name)
	VALUES([inputName]);

-- Mass loading of party
LOAD DATA LOCAL INFILE '/path/contest_type.data' INTO TABLE contest_type
LINES TERMINATED BY '\r\n';

INSERT INTO contest_type
	VALUES([inputTypeName]);


-- Load candidate information from file
LOAD DATA LOCAL INFILE '/path/candidate.data' INTO TABLE candidate
LINES TERMINATED BY '\r\n';

-- Query for use on site
INSERT INTO candidate
	values([inputFname], [inputLname], [inputPartyId]);


-- Load candidate information from file
LOAD DATA LOCAL INFILE '/path/contest.data' INTO TABLE contest
LINES TERMINATED BY '\r\n';

INSERT INTO contest
	values([inputDate], [inputState], [inputParty], [intputContestType]);



-- Load voting details from file
LOAD DATA LOCAL INFILE '/path/contest_candidate.data' INTO TABLE contest_candidate
LINES TERMINATED BY '\r\n';

-- Query for site
INSERT INTO contest_candidate
	values([inputCandidateId], [inputContestId], [inputVoteCount], [inputDelegateCount]);


-- Delete a row from various tables ... double check requirements, I think if we do aggregate functions then not required.

-- Some queries to do

-- Get basic information relating to a single candidate
SELECT 
	CONCAT(`fname`, ' ', `lname`) AS 'Candidate',
	p.name AS 'Party Affiliation'
FROM
	`candidate` AS c
INNER JOIN
	`party` AS p ON c.party_id=p.id
WHERE
	'Candidate'=[inputFullName]
;

-- Get the details on all of the contests in one table
-- This should select the date, state, party, and contest types for 
-- all of the contests. Could filter the results easily by adding a
-- WHERE statement. For example, WHERE state.id=userinput
SELECT
	contest.date as 'Date',
	state.name as 'State',
	party.name as `Party`,
	type.name as `Contest Type`
INNER JOIN
	state ON state.id=contest.state_id
INNER JOIN
	party ON party.id=contest.party_id
INNER JOIN
	contest_type AS type ON type.id=contest.contest_type_id
;

-- Possible "filters" to apply:
-- All contests (typically just 2?) for a particular state
WHERE 
	state.name=[stateinput]
-- all contests for a particular party across all states
WHERE
	party.name=[partyInput]
-- combine them to get the specific contest for a specific party
WHERE
	state.name=[stateinput]
	AND
	party.name=[partyInput]



-- Retrieve all rows from contest_candidate for a particular candidate
-- Can use this to sum up their votes and delegate count
SELECT
	CONCAT(c.`fname`, ' ', c.`lname`) AS 'Candidate',
	p.`name` AS 'Party',
	SUM(details.vote_count) AS 'Total Votes',
	SUM(details.delegate_count) AS `Total Delegates`
FROM 
	candidate as c
INNER JOIN
	party AS p
	ON p.id=c.party_id
INNER JOIN
	contest_candidate AS details
	ON details.candidate_id=candidate.id
GROUP BY
	details.candidate_id
WHERE
	'Candidate'=[inputFullName]  -- Where clause might need to be before the group by clause??
ORDER BY
	`Total Votes`, `Total Delegates`



-- Do a query to get the candidate at the 




-- Get the contest details for a specific contest by using the state and party (which form the composite key for the contest table)
SELECT
	-- Where to start? Suppose we want all of the rows from contest_candidate for a certain state
	-- So we'd need to select the vote count and/or delegate count from contest_candidate by 
	-- joining the contest and candidate id's
	s.`name` AS 'State'
FROM
	`state` AS s
INNER JOIN
	`contest` AS c ON s.id=c.state_id
INNER JOIN
	`contest_candidate` AS votes ON c.id=votes.contest_id
INNER JOIN
	`candidate` as cand ON cand.id=c.candidate_id
WHERE 
