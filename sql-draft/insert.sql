-- --------------------------------------------------------------------------------------------------
-- Authors:       Shawn S Hillyer, Jason Goldfine-Middleton
-- Description:   Contains the queries we will use in the web interface that
--                allow the user to add additional data to the database.
-- --------------------------------------------------------------------------------------------------



-- --------------------------------------------------------------------------------------------------
-- Queries used to insert into database.
-- There is one insert query for each table.
-- User won't be able to change the data in most of the tables as they are mostly immutable pieces
-- of data. However, for contest, we can allow updating the date and contest type.
-- Other update maintenance would be done on a more back-end database, anyways, and probably just
-- loadeded from file upon creation (as we do for the "real" data)
-- --------------------------------------------------------------------------------------------------


-- Add a state to the table state
-- Form should validate that name and abbreviation or not NULL / whitespace-only
-- Form should validate that the abbreviation is exactly two characters
-- In ideal world, this would be populated by a sysadmin and loaded into the database, not a user
INSERT INTO state(name, abbreviation)
	VALUES([inputName], [inputAbbreviation]);


-- Add a party ("republican", "democrat") to the party table
-- Form should validate that party name is at least 3 characters long and not NULL / whitespace-only
INSERT INTO party(name)
	VALUES([inputName]);


-- Add a contest type (caucus, primary, etc) to the contest_type table
-- Probably only a couple of rows in the table but using this keeps our database more normalized
-- Form should validate that type is not NULL or whitespace-only string
INSERT INTO contest_type(name)
	VALUES([inputTypeName]);


-- Add a candidate to the candidate table
-- Form should validate that all fields (fname, lname, party) are not null
-- The form should load a dropdown box for the party by querying and selecting party.name
-- and fill the dropdown with the options. On submit, a query should be made against
-- the party table to find the party id and then insert that value
		-- Any way to write this subquery as some kind of function?
		-- Alternatively, we could have the form run two queries:
		--  1) Query on the string to lookup the ID and assign to a variable
		--  2) Use that variable to submit this query but replacing the subquery with the id we looked up
INSERT INTO candidate(fname, lname, party_id)
	VALUES([inputFName], [inputLname], 
		(SELECT p.id FROM party AS p WHERE p.name=[inputPartyName])
	)
;



-- Add a contest to the contest table
-- Form should have an HTML calendar to select the date -- this helps validate the input. Can also
-- validate the date and verify that user doesn't input a date that is before/after a certain date 
-- (like, not before 1/1/16 and not after 12/31/16 or whatever the real cutoffs are)
-- We also have to lookup the state and party id's to submit to this table. Not sure if we should use
-- multiple queries and use php to store the variables from each and then submit all as a final query
-- to the database to keep the insert statement itself clean, or if there's a cleaner way in mysql to
-- do this. Ask Jason / investigate!
INSERT INTO contest(contest_date, state_id, party_id, contest_type_id)
	VALUES
		(	[inputContestDate], 
			(SELECT id FROM state WHERE state.name=[inputContestState]), 
			(SELECT id FROM party WHERE party.name=[inputContestParty]),
			(SELECT id FROM contest_type WHERE contest_type.name=[inputContestType]) 
		);


-- Add the details about a specific candidate's results at a specific contest
-- Form should allow us to pick a candidate and a state from all of the ones in our database
-- which they can then just type in the number of votes or delegates for and submit.
-- 1) Query database for all candidates and fill in a dropdown for that
-- 2) Query database for all states and fill in a dropdown for that
-- 3) a number field for user to type in a non-NULL number into at least one or the other
--   (whichever of the two is blank I guess we'd insert NULL to database)
-- 4) When user submits the form, we do a lookup again to get the candidate.id and state.id,
--   store those and use as arguments to find the party.id which we can use to find the contest.id
-- Once we have the contest id, we can finally do step 5...
-- 5) Submit the insert using the candidate.id, contest.id, and votecount that we calculated
INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count)
	VALUES
	(	(SELECT id FROM candidate WHERE candidate.fname=[inputFName] AND candidate.lname=[inputLName]),
		(SELECT id FROM contest 
			WHERE contest.state_id=(SELECT id FROM state WHERE state.name=[inputState])
				AND 
			contest.party_id=(SELECT id FROM party WHERE party.name=[inputParty])
		),
		10,
		NULL
	)
;