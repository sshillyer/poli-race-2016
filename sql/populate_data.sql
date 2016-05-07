-- Sample data which can be appending to polirace.sql in a sqlfiddle.com entry to test our database


-- --------------------------------------------------------------------------------------------------
INSERT INTO state(name, abbreviation)
	VALUES
		("Oregon", "OR"),
		("California", "CA"),
		("Washington", "WA")
;


-- --------------------------------------------------------------------------------------------------
INSERT INTO party(name)
	VALUES
		("Democrat"),
		("Republican")
;


-- --------------------------------------------------------------------------------------------------
INSERT INTO candidate(fname, lname, party_id)
	VALUES
		("Jeb", "Busch", (SELECT id FROM party WHERE party.name="Republican")),
		("Hillary", "Clinton", (SELECT id FROM party WHERE party.name="Democrat"))
;


-- --------------------------------------------------------------------------------------------------
INSERT INTO contest_type(name)
	VALUES
		("Caucus"),
		("Primary")
;


-- --------------------------------------------------------------------------------------------------
INSERT INTO contest(contest_date, state_id, party_id, contest_type_id)
	VALUES
		(	"2016-12-31", 
			(SELECT id FROM state WHERE state.name="Oregon"), 
			(SELECT id FROM party WHERE party.name="Republican"),
			(SELECT id FROM contest_type WHERE contest_type.name="Caucus") 
		),

		(	"2016-01-15", 
			(SELECT id FROM state WHERE state.name="California"), 
			(SELECT id FROM party WHERE party.name="Democrat"),
			(SELECT id FROM contest_type WHERE contest_type.name="Primary") 
		)
;


-- --------------------------------------------------------------------------------------------------
-- Need to test this one again, there was some missing logic
-- Also, might be wise to make the lookupg for contest_id an inner join instead of subqueries... tired, so not sure
INSERT INTO contest_candidate(candidate_id, contest_id, vote_count, delegate_count) 
VALUES ((SELECT id FROM candidate WHERE candidate.fname="Jeb" AND candidate.lname="Busch"), 
(SELECT id FROM contest WHERE contest.state_id=(SELECT id FROM state WHERE state.name="Oregon") AND contest.party_id=(SELECT id FROM party WHERE party.name="Republican")),
 10, 
 0);