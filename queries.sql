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
  CONCAT(`fname`, ' ', `lname`)=[inputFullName]
; -- TESTED: WORKS
-- OUTPUT:
-- Candidate	name
-- Jeb Busch	Republican



-- Get the details on all of the contests in one table
-- This should select the date, state, party, and contest types for 
-- all of the contests. Could filter the results easily by adding a
-- WHERE statement. For example, WHERE state.id=userinput
SELECT
	contest.contest_date as 'Date',
	state.name as 'State',
	party.name as `Party`,
	type.name as `Contest Type`
FROM
  contest
INNER JOIN
	state ON state.id=contest.state_id
INNER JOIN
	party ON party.id=contest.party_id
INNER JOIN
	contest_type AS type ON type.id=contest.contest_type_id
; -- TESTED: Working
-- OUTPUT:
-- contest_date	name	name	name
-- December, 31 2016 00:00:00	Oregon	Republican	Caucus
-- January, 15 2016 00:00:00	California	Democrat	Primary

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
	ON details.candidate_id=c.id
WHERE
	CONCAT(c.`fname`, ' ', c.`lname`)=[inputFullName]
GROUP BY
	details.candidate_id  -- Where clause might need to be before the group by clause??
;

-- Perhaps sort like so instead of where for another query
ORDER BY
	`Total Votes`, `Total Delegates` DESC



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
