<?php
ini_set('display_errors', 'On');
require_once('helpers.php');
require_once("select-table.php");
require_once("Page.php");

// Create new Page object and display top of page content
$page = new Page();
$page->header = 'Display All Parties';
$page->DisplayTop();

// Extract the query type. 
$query_type = ($_POST['query_selection']);


switch ($query_type) {
	// Display States
	case "all_states":
		$query =
				"SELECT
					`name` AS `State`,
					`abbreviation` AS `Abbreviation`
				FROM
					`state` AS s
				ORDER BY
					`State` ASC";

		break;


	// Display Political Parties
	case "all_parties":
		$query = 
				"SELECT
					`name` AS `Party`
				FROM
					`party` AS p
				ORDER BY
					`Party` ASC";

		break;


	// Display Types of Contests
	case "all_contest_types":
		$query = 
				"SELECT
					`name` AS `Contest Type`
				FROM
					`contest_type` AS ct
				ORDER BY
					`Contest Type` ASC";

		break;


	// Display Political Candidates
	case "all_candidates":
		$query = 
				"SELECT 
					CONCAT(c.`fname`, ' ', c.`lname`) AS 'Candidate',
					p.`name` AS 'Party'
				FROM
					`candidate` AS c
				INNER JOIN
					`party` AS p ON c.`party_id` = p.`id`
				ORDER BY
					'Candidate' ASC";

		break;

	// Display Contest Events 
	case "all_contests":
		$query = 
				"SELECT
					DATE(`contest`.`contest_date`) AS `Date`,
					`state`.`name` AS `State`,
					`party`.`name` AS `Party`,
					`type`.`name` AS `Contest Type`
				FROM
				  	`contest`
				INNER JOIN
					`state` ON `state`.`id` = `contest`.`state_id`
				INNER JOIN
					`party` ON `party`.`id` = `contest`.`party_id`
				INNER JOIN
					`contest_type` AS `type` ON `type`.`id`=`contest`.`contest_type_id`";

		break;


	// Display Contest Events
	case "all_contest_candidates":
		$query = 
				"SELECT
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
					ON `details`.`candidate_id` = c.`id`
				GROUP BY
					`details`.`candidate_id`";

		break;

	// Additional query routes can be below here :)

	// Display Delegates Available in Each Contest
	case "all_contest_delegates":
		$query = 
				"SELECT
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
				ORDER BY `State` ASC, `Party` ASC";

		break;

	// Display each candidate's most recent win
	case "most_recent_wins":
		$query =
				"SELECT
					CONCAT(cn.`fname`, ' ', cn.`lname`) AS `Winner`,
					pty.`name` AS `Party`,
					st.`name` AS `State`,
					ct.`name` AS `Event`,
					DATE(`recent_win`.`contest_date`) AS `Date`,
					ctc.`delegate_count` AS `Delegates Won`,
					ctc.`vote_count` AS `Votes Received`,
					cs.`delegates` AS `Total Delegates`
				FROM
					(
					SELECT
						can.`id` AS `candidate_id`,
						MAX(c.`contest_date`) AS `contest_date`
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
									AND `recent_win`.`contest_date` = cs.`contest_date`
				INNER JOIN
					`contest_type` AS ct ON ct.`id` = cs.`contest_type_id`
				INNER JOIN
					`party` AS pty ON pty.`id` = cn.`party_id`
				INNER JOIN
					`state` AS st ON st.`id` = cs.`state_id`
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
					`Party` ASC";
}


build_table_from_query($query);

insert_button("../queries.php", "Select Different Query");
insert_button("../index.php", "Insert More Data");
// $page->DisplayBottom();

?>