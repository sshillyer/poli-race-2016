-- Sample data which can be appending to polirace.sql in a sqlfiddle.com entry to test our database


-- --------------------------------------------------------------------------------------------------
INSERT INTO state(name, abbreviation)
	VALUES
		("Alabama", "AL"),
		("Alaska", "AK"),
		("Arizona", "AZ"),
		("Arkansas", "AR"),
		("California", "CA"),
		("Colorado", "CO"),
		("Connecticut", "CT"),
		("Delaware", "DE"),
		("Florida", "FL"),
		("Georgia", "GA"),
		("Hawaii", "HI"),
		("Idaho", "ID"),
		("Illinois", "IL"),
		("Indiana", "IN"),
		("Iowa", "IA"),
		("Kansas", "KS"),
		("Kentucky", "KY"),
		("Louisiana", "LA"),
		("Maine", "ME"),
		("Maryland", "MD"),
		("Massachusetts", "MA"),
		("Michigan", "MI"),
		("Minnesota", "MN"),
		("Mississippi", "MS"),
		("Missouri", "MO"),
		("Montana", "MT"),
		("Nebraska", "NE"),
		("Nevada", "NV"),
		("New Hampshire", "NH"),
		("New Jersey", "NJ"),
		("New Mexico", "NM"),
		("New York", "NY"),
		("North Carolina", "NC"),
		("North Dakota", "ND"),
		("Ohio", "OH"),
		("Oklahoma", "OK"),
		("Oregon", "OR"),
		("Pennsylvania", "PA"),
		("Rhode Island", "RI"),
		("South Carolina", "SC"),
		("South Dakota", "SD"),
		("Tennessee", "TN"),
		("Texas", "TX"),
		("Utah", "UT"),
		("Vermont", "VT"),
		("Virginia", "VA"),
		("Washington", "WA"),
		("West Virginia", "WV"),
		("Wisconsin", "WI"),
		("Wyoming", "WY")
;


-- --------------------------------------------------------------------------------------------------
INSERT INTO party(name)
	VALUES
		("Democrat"),
		("Republican"),
		("Independent"),
		("Libertarian"),
		("Green"),
		("Constitution"),
		("American Freedom")
;


-- --------------------------------------------------------------------------------------------------
-- More can be found here: http://www.nytimes.com/interactive/2016/us/elections/2016-presidential-candidates.html?_r=0
INSERT INTO candidate(fname, lname, party_id)
	VALUES
		("Jeb", "Busch", (SELECT id FROM party WHERE party.name="Republican")),
		("Hillary", "Clinton", (SELECT id FROM party WHERE party.name="Democrat")),
		("Donald", "Trump", (SELECT id FROM party WHERE party.name="Republican")),
		("Bernie", "Sanders", (SELECT id FROM party WHERE party.name="Democrat")),
		("Bob", "Whitacker", (SELECT id FROM party WHERE party.name="American Freedom")),
		("Tom", "Bowie", (SELECT id FROM party WHERE party.name="American Freedom")),
		("Darrell", "Castle", (SELECT id FROM party WHERE party.name="Constitution")),
		("Scott", "Bradley", (SELECT id FROM party WHERE party.name="Constitution"))
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