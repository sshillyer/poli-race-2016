-- Some queries to do

-- Get basic information relating to a single candidate
SELECT 
	CONCAT(`fname`, ' ', `lname`) AS 'Candidate',
	p.`name` AS 'Party Affiliation'
FROM
	`candidate` AS c
INNER JOIN
	`party` AS p ON c.`party_id`=p.`id`
WHERE
  CONCAT(`fname`, ' ', `lname`)=[inputFullName]
; -- TESTED: WORKS
-- OUTPUT:
-- Candidate	Party Affiliation
-- Jeb Bush		Republican



-- Get the details on all of the contests in one table
-- This should select the date, state, party, and contest types for 
-- all of the contests. Could filter the results easily by adding a
-- WHERE statement. For example, WHERE state.id=userinput
SELECT
	DATE(`contest`.`contest_date`) as `Date`,
	`state`.`name` as `State`,
	`party`.`name` as `Party`,
	`type`.`name` as `Contest Type`
FROM
  	`contest`
INNER JOIN
	`state` ON `state`.`id`=`contest`.`state_id`
INNER JOIN
	`party` ON `party`.`id`=`contest`.`party_id`
INNER JOIN
	`contest_type` AS `type` ON `type`.`id`=`contest`.`contest_type_id`
; -- TESTED: Working
-- OUTPUT:
-- Date					State		Party		Contest Type
-- December, 31 2016	Oregon		Republican	Caucus
-- January, 15 2016		California	Democrat	Primary

-- Possible "filters" to apply:
-- All contests (typically just 2?) for a particular state
WHERE 
	`state`.`name`=[stateinput]
-- all contests for a particular party across all states
WHERE
	`party`.`name`=[partyInput]
-- combine them to get the specific contest for a specific party
WHERE
	`state`.`name`=[stateinput]
	AND
	`party`.`name`=[partyInput]



-- Retrieve all rows from contest_candidate for a particular candidate
-- Can use this to sum up their votes and delegate count
SELECT
	CONCAT(c.`fname`, ' ', c.`lname`) AS `Candidate`,
	p.`name` AS 'Party',
	SUM(`details`.`vote_count`) AS `Total Votes`,
	SUM(`details`.`delegate_count`) AS `Total Delegates`
FROM 
	`candidate` as c
INNER JOIN
	`party` AS p
	ON p.`id`=c.`party_id`
INNER JOIN
	`contest_candidate` AS `details`
	ON `details`.`candidate_id`=c.`id`
WHERE
	CONCAT(c.`fname`, ' ', c.`lname`)=[inputFullName]
GROUP BY
	`details`.`candidate_id`  -- Where clause might need to be before the group by clause??
; -- TESTED: Seems to work, need more data rows in tables to verify

-- Perhaps sort like so instead of where for another query
ORDER BY
	`Total Votes` DESC, `Total Delegates` DESC



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
	`contest` AS c ON s.`id`=c.`state_id`
INNER JOIN
	`contest_candidate` AS `votes` ON c.`id`=`votes`.`contest_id`
INNER JOIN
	`candidate` as `cand` ON `cand`.`id`=c.`candidate_id`
WHERE 


-- Get the number of delegates per party for each state.  This assumes we have a column
-- in the `contest` table that contains the total number of delegates for the given party and state.
SELECT
	s.`name` AS `State`,
	p.`name` AS `Party`,
	c.`delegates` AS `Delegates`,
	1.0 * c.`delegates` / `total_delegates`.`dels` AS `Percentage of Total Delegates`
FROM
	`state` AS s
INNER JOIN
	`contest` AS c ON s.`id` = c.`state_id`
INNER JOIN
	`party` AS p ON c.`party_id` = p.`id`;
INNER JOIN
	(
	SELECT
		co.`party_id`,
		SUM(co.`delegates`) AS `dels`
	FROM
		`contest` AS co
	GROUP BY
		co.`party_id`
	) `total_delegates` ON `total_delegates`.`party_id` = p.`id`
ORDER BY `State` ASC, `Party` ASC
;


-- Display the candidates from a particular party in order of delegates earned

-- Have to use this method because MySQL doesn't have window functions :(
-- Source: http://stackoverflow.com/a/14297055
SET @prev = NULL;
SET @rnk = 0;
SELECT
	CASE WHEN @prev  = `Delegates` THEN @rnk
		 WHEN @prev := `Delegates` THEN @rnk := @rnk + 1
	END AS `Ranking`,
	CONCAT(c.`fname`, ' ', c.`lname`) AS `Candidate`,
	`total_delegates`.`dels` AS `Delegates`
FROM
	`contest_candidate` AS cc
INNER JOIN
	`candidate` AS c ON c.`id` = cc.`candidate_id`
INNER JOIN
	(
	SELECT
		ca.`candidate_id`,
		SUM(co.`delegates`) AS `dels`
	FROM
		`contest_candidate` AS cca
	INNER JOIN
		`contest` AS co ON co.`id` = cca.`contest_id`
	INNER JOIN
		`candidate` AS ca ON ca.`id` = cca.`candidate_id`
	INNER JOIN
		`party` AS p ON p.`id` = ca.`party_id`
	WHERE
		p.`name` = [partyInput]
	GROUP BY
		ca.`candidate_id`
	) `total_delegates` ON `total_delegates`.`candidate_id` = c.`id`
ORDER BY  -- may have to pre-order in the sub-query so the order is
		  -- correct before ranking, haven't checked
	`Delegates` DESC
;


-- Show each candidate's most recent win, if there was one

-- No idea if this is correct... wish there was a good way to avoid having the same subquery twice.
SELECT
	CONCAT(cn.`fname`, ' ', cn.`lname`) AS `Winner`,
	pty.`name` AS `Party`,
	ct.`name` AS `Event`,
	DATE(`recent_win`.`contest_date`) AS `Date`,
	ctc.`delegate_count` AS `Delegates Won`,
	CASE WHEN `Event` = 'primary' THEN CONVERT(ctc.`vote_count`, VARCHAR(3))
		 ELSE 'N/A'
	END AS `Votes Received`,
	cs.`delegates` AS `Total Delegates`
FROM
	(
	SELECT
		can.`id` AS `candidate_id`,
		MAX(c.`date`) AS `contest_date`
	FROM
		(
		SELECT
			con.`id` AS `contest_id`,
			MAX(conca.`delegate_count`) AS `max_dels`
		FROM
			`contest` AS con
		INNER JOIN
			`contest_candidate` AS conca ON conca.`contest_id` = con.`id`
		GROUP BY
			con.`id`
		) `max_per_contest`
	INNER JOIN
		`contest_candidate` AS cc ON cc.`contest_id` = `max_per_contest`.`contest_id`
	INNER JOIN
		`candidate` AS can ON can.`id` = cc.`candidate_id`
	INNER JOIN
		`contest` AS c ON c.`id` = cc.`contest_id`
	WHERE
		cc.`delegate_count` = `max_per_contest`.`max_dels`
	GROUP BY
		`candidate_id`
	) `recent_win`
INNER JOIN
	`candidate` AS cn ON cn.`id` = `recent_win`.`candidate_id`
INNER JOIN
	`contest_candidate` AS ctc ON ctc.`candidate_id` = cn.`id`
INNER JOIN
	`contest` AS cs ON cs.`id` = ctc.`contest_id`
					AND `recent_win`.`contest_date` = cs.`date`
INNER JOIN
	`contest_type` AS ct ON ct.`id` = cs.`contest_type_id`
INNER JOIN
	`party` AS pty ON pty.`id` = cn.`party_id`
INNER JOIN
	(
	SELECT
		con.`id` AS `contest_id`,
		MAX(conca.`delegate_count`) AS `max_dels`
	FROM
		`contest` AS con
	INNER JOIN
		`contest_candidate` AS conca ON conca.`contest_id` = con.`id`
	GROUP BY
		con.`id`
	) `max_per_contest` ON `max_per_contest`.`contest_id` = cs.`id`
						AND `max_per_contest`.`max_dels` = ctc.`delegate_count`
ORDER BY
	`Party` ASC
;