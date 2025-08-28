<?php
   // Admin Query
   define('criteriaPercentageList', 'SELECT SUM(percent) AS percent FROM event_criteria WHERE event_code = ?');
   define('judgeList', 'SELECT code, name, category from user Where types = "isJudge" order by code asc');
   define('judgeEventScoreList', 'SELECT code, event_type_code, event_code, judge_code, contestant_code, score from event_score Where event_code = ? AND contestant_code = ? AND judge_code = ?');
   define('judgeEventScoreSummaryList', 'SELECT SUM(score) AS total_score FROM event_score WHERE contestant_code = ? AND judge_code = ?');
   define('judgeCountList', 'SELECT COUNT(code) AS judge_count from user Where types = "isJudge"');
   define('judgeAccountList', 'SELECT code, username, password, name, category, is_both from user Where types = "isJudge" order by code asc');
   define('contestantCount', 'SELECT COUNT(code) AS contestant_size FROM contestant');
   define('contestantCountByCategory', 'SELECT COUNT(code) AS contestant_size FROM contestant WHERE category_code = ?');

   define('criteriaPercentageListFinal', 'SELECT SUM(percent) AS percent FROM event_criteria WHERE criteria_type = "F" AND event_code = ?');
   define('contestantByCategoryList', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = ?');
   define('contestantByCategoryFinalList', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE category_code = ? AND is_finalist = "1"');
   define('contestantCategoryList', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("FE", "MA", "B")');
   
   define('eventScoreList', 'SELECT score from event_score Where event_code = ? AND contestant_code = ? AND judge_code = ? AND criteria_code = ?');
   define('eventJudgeSelected', 'SELECT name FROM user WHERE types = "isJudge" AND code = ?');
   
   define('judgeScoreUpdate', 'SELECT code, score, criteria_code FROM event_score WHERE contestant_code = ? AND judge_code = ? AND event_code = ?');
   // judge Query
   define('contestantLast', 'SELECT code FROM contestant ORDER BY code DESC LIMIT 1');
   define('contestantList', 'SELECT code, sequence, name, category_code, gender FROM contestant');
   define('contestantListFinal', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE is_finalist = 1');

   define('criteriaList', 'SELECT code, event_code, criteria_name, percent FROM event_criteria WHERE event_code = ?');
   define('criteriaListAll', 'SELECT code, event_code, criteria_name, percent FROM event_criteria');
   define('criteriatListPreliminary', 'SELECT code, event_code, criteria_name FROM event_criteria WHERE event_code = ?');
   define('criteriaListJudgeScore', 'SELECT code, event_code, criteria_name, percent FROM event_criteria WHERE event_code = ?');
   
   define('eventScoreLast', 'SELECT code FROM event_score ORDER BY code DESC LIMIT 1');
   define('eventScoreAdd', 'INSERT INTO event_score (code, event_code, event_type_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)');
   define('eventScoreUpdate', 'UPDATE event_score SET score = ?, category_code = ?, updated_timestamp = CURRENT_TIMESTAMP WHERE event_code = ? AND judge_code = ? AND criteria_code = ? AND contestant_code = ? ');
   define('eventScoreCheckForExistingScore', 'SELECT code, event_code, judge_code, criteria_code, contestant_code, score FROM event_score WHERE event_code = ? AND judge_code = ? AND contestant_code = ?');
   define('eventScoreOverallScore', 'SELECT SUM(score) AS overall, event_code, contestant_code FROM event_score WHERE event_code = ? AND contestant_code = ? AND event_type_code = ? AND judge_code = ? GROUP BY event_code, contestant_code');
   define('eventCount', 'SELECT COUNT(code) AS event_size FROM event');


   define('addJudge', 'INSERT INTO user (code, username, password, name, types, category, is_both, status, added_by, added_timestamp) VALUES (?, ?, ?, ?, "isJudge", ?, ?, "1", ? ,CURRENT_TIMESTAMP)');
   define('updateJudge','UPDATE user SET username = ?, password = ?, name = ?, category = ?, is_both = ?, updated_by = ?, updated_timestamp = CURRENT_TIMESTAMP WHERE code = ?');
   define('updateViewJudge', 'SELECT * FROM user WHERE types = "isJudge" AND  code = ?');
   define('deleteJudge', 'DELETE FROM user WHERE code = ?');
   define('judgeLast', 'SELECT code FROM user ORDER BY code DESC LIMIT 1');
   define('judgeValList', 'SELECT code, username, password, name, category from user Where types = "isJudge" order by code asc');
   
   //Super Query
   define('addCriteria', 'INSERT INTO event_criteria (code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)');
   define('updateCriteria', 'UPDATE event_criteria SET criteria_type = ?, event_code = ?, criteria_name = ?, percent = ?, updated_by = ?, updated_timestamp = CURRENT_TIMESTAMP WHERE code =?');
   define('deleteCriteria', 'DELETE FROM event_criteria WHERE code = ?');
   define('criteriaViewUpdate', 'SELECT code, criteria_type, event_code, criteria_name, percent FROM event_criteria WHERE code = ?');
   define('criteriaTblList', 'SELECT code, criteria_type, event_code, criteria_name, percent FROM event_criteria');
   define('superAccountList', 'SELECT code, username, password, name, category, is_both from user Where types = "isSuper" order by code asc');

   define('addEvent', 'INSERT INTO event (code, event_type, event_name, event_percentage, added_by, added_timestamp) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)');
   define('updateEvent', 'UPDATE event SET event_type = ?, event_name = ?, event_percentage = ?,  updated_by = ?, updated_timestamp = CURRENT_TIMESTAMP WHERE code= ?');
   define('deleteEvent', 'DELETE FROM event WHERE code = ?');
   define('viewEventUpdate', 'SELECT code, event_type, event_name, event_percentage FROM event WHERE code = ?');
   define('eventTblList', 'SELECT code, event_type, event_name, event_percentage FROM event');
   define('eventObjList', 'SELECT code, event_type, event_name, event_percentage FROM event WHERE code = ?');

   define('addContestant', 'INSERT INTO contestant (code, sequence, name, is_finalist, category_code, gender, is_both) VALUES (?, ?, ?, 0, ?, ?, ?)');
   define('updateContestant', 'UPDATE contestant SET sequence = ?, name = ?, category_code = ?, gender = ?, is_both = ? WHERE code = ?');
   define('deleteContestant', 'DELETE FROM contestant WHERE code = ?');
   define('viewContestantUpdate', 'SELECT code, sequence, name, is_finalist, category_code, gender, is_both FROM contestant WHERE code = ?');
   define('contestantTblList', 'SELECT * FROM contestant');

   define('addSettings', 'INSERT INTO setting (condition_final, pageant_name) VALUES (?, ?, ?)');
   define('updateSettings', 'UPDATE setting SET condition_final = ?, pageant_name = ?, isGeneral = ? WHERE id = ?');
   define('deleteSettings', 'DELETE FROM setting WHERE id = ?');
   define('settingList', 'SELECT * FROM setting');
   define('settingViewList', 'SELECT * FROM setting WHERE id = ?');

   //Special Event
   define('eventListSpecial', 'SELECT code, event_type, event_name FROM event WHERE event_type = "SP"');
   define('eventListSpecialList', 'SELECT code, event_type, event_name FROM event WHERE event_type = "SP" AND code = ?');


   //General Query
   define('eventListPreliminary', 'SELECT code, event_type, event_name FROM event WHERE event_type = "PR"');
   
   define('eventListPreliminaryList', 'SELECT code, event_type, event_name FROM event WHERE event_type = "PR" AND code = ?');
   
   define('eventListPreliminaryListFinal', 'SELECT code, event_type, event_name FROM event WHERE event_type = "F" AND code = ?');
   
   define('eventListFinal', 'SELECT code, event_type, event_name FROM event WHERE event_type = "F"');
   
   define('eventList', 'SELECT code, event_type, event_name FROM event WHERE event_type = "PR"');
   
   define('eventListAll', 'SELECT code, event_type, event_name FROM event');

   define('eventListJudgeScore', 'SELECT code, event_type, event_name FROM event WHERE code = ?');
   
   define('overallSummaryOverallSummary', 'SELECT SUM(score) AS overallSummary, event_code FROM event_score WHERE event_code = ? AND contestant_code = ? GROUP BY event_code');
   
   define('eventPercentage', 'SELECT SUM(event_percentage) AS event_percent FROM event WHERE event_type = "PR"');
   
   define('criteriaPercentage', 'SELECT SUM(percent) AS cretiria_percent FROM event_criteria WHERE criteria_type = "PR"');

   define('criteriaPercentageFinal', 'SELECT SUM(percent) AS cretiria_percent FROM event_criteria WHERE criteria_type = "F"');
   
   define('allEventList', 'SELECT code, event_name FROM event');

   define('eventLast', 'SELECT code FROM event ORDER BY code DESC LIMIT 1');

   define('criteriaLast', 'SELECT code FROM event_criteria ORDER BY code DESC LIMIT 1');

   define('eventPercentageFinal', 'SELECT SUM(event_percentage) AS event_percent FROM event WHERE event_type = "F"');

   define('judgeByCategoryList', 'SELECT category, is_both from user WHERE code = ?');
   
   define('contestantCategoryByJudge', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE category_code = ?');

   define('contestantCategoryByJudgeFinal', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE is_finalist = "1" AND category_code = ?');

   define('judgeByCategorySummaryList', 'SELECT code, name, category from user WHERE category = ?');

   define('judgeCountByCategoryList', 'SELECT COUNT(code) AS judge_count_by_category from user Where types = "isJudge" AND category = ?');

   define('OverallSummaryByCategory', 'SELECT SUM(score) AS overallSummary, event_code FROM event_score WHERE event_code = ? AND contestant_code = ? AND category_code = ? GROUP BY event_code');

   define('contestantListToUpdate', 'SELECT code, sequence, name, category_code FROM contestant WHERE code = ?');

   define('eventJudgeScoreUpdate', 'UPDATE event_score SET score = ? WHERE code = ?');

   define('criteriaPercentUpdate', 'SELECT percent FROM event_criteria WHERE code = ?');

   define('judgeByCategorySummaryListMale', 'SELECT code, name, category from user WHERE category IN ("MA", "B")');

   define('judgeByCategorySummaryListFemale', 'SELECT code, name, category from user WHERE category IN ("FE", "B")');

   define('judgeByCategorySummaryListMaleFemale', 'SELECT code, name, category from user WHERE category IN ("MA", "FE", "B")');

   define('contestantByCategoryListFinal', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE is_finalist = "1" category_code = ?');

   define('contestantListFemaleMale', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("FE" ,"MA")');

   define('contestantListFemaleMaleBoth', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("FE" ,"MA") AND is_both = "1"');

   define('contestantListLgbtq', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("LGBTQ-LES" ,"LGBTQ-GAY")');

   define('contestantListLgbtqBoth', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("LGBTQ-LES" ,"LGBTQ-GAY") AND is_both = "2"');

   define('contestantListFinalFemaleMale', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("FE" ,"MA") AND is_finalist = 1 ');

   define('contestantListFinalLgbtq', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code IN ("LGBTQ-LES" ,"LGBTQ-GAY") AND is_finalist = 1 ');

   define('contestantListFemale', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = "FE"');

   define('contestantListMale', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = "MA"');

   define('contestantListMaleFemale', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = "MA" AND is_both = "1"');

   define('contestantListGay', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = "LGBTQ-GAY"');

   define('contestantListLesbian', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = "LGBTQ-LES"');

   define('contestantListGayLesbian', 'SELECT code, sequence, name, is_finalist, category_code, gender FROM contestant WHERE category_code = "LGBTQ-GAY" AND is_both = "2"');

   define('judgeCountByCategoryListFemale', 'SELECT COUNT(code) AS judge_count_by_category from user Where types = "isJudge" AND category = "FE"');

   define('judgeCountByCategoryListMale', 'SELECT COUNT(code) AS judge_count_by_category from user Where types = "isJudge" AND category = "MA"');

   define('contestantCountByCategoryFemale', 'SELECT COUNT(code) AS contestant_size FROM contestant WHERE category_code = "FE"');

   define('contestantCountByCategoryMale', 'SELECT COUNT(code) AS contestant_size FROM contestant WHERE category_code = "MA"');

   define('judgeByCategorySummaryListLesbian', 'SELECT code, name, category from user WHERE category IN ("LGBTQ-LES", "LGBTQ-B")');

   define('judgeByCategorySummaryListGay', 'SELECT code, name, category from user WHERE category IN ("LGBTQ-GAY", "LGBTQ-B")');

   define('judgeByCategorySummaryListGayLesbian', 'SELECT code, name, category from user, is_both WHERE category IN ("LGBTQ-GAY", "LGBTQ-LES", "LGBTQ-B")');

   define('judgeCountListFemale', 'SELECT COUNT(code) AS judge_count from user Where types = "isJudge" AND category IN ("FE", "B")');

   define('judgeCountListMale', 'SELECT COUNT(code) AS judge_count from user Where types = "isJudge" AND category IN ("MA", "B")');

   define('judgeCountListLesbian', 'SELECT COUNT(code) AS judge_count from user Where types = "isJudge" AND category IN ("LGBTQ-LES", "LGBTQ-B")');

   define('judgeCountListGay', 'SELECT COUNT(code) AS judge_count from user Where types = "isJudge" AND category IN ("LGBTQ-GAY", "LGBTQ-B")');

   define('contestantByCategoryFinalListFemale', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE is_finalist = "1" AND category_code IN ("FE", "B")');

   define('contestantByCategoryFinalListMale', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE is_finalist = "1" AND category_code IN ("MA", "B")');

      define('contestantByCategoryFinalListMaleFemale', 'SELECT code, sequence, name, category_code, gender, is_both FROM contestant WHERE is_finalist = "1" AND category_code IN ("MA", "FE", "B") AND is_both = "1"');

   define('contestantByCategoryFinalListLesbian', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE is_finalist = "1" AND category_code IN ("LGBTQ-LES", "LGBTQ-B")');

   define('contestantByCategoryFinalListGay', 'SELECT code, sequence, name, category_code, gender FROM contestant WHERE is_finalist = "1" AND category_code IN ("LGBTQ-GAY", "LGBTQ-B")');

   define('userLast', 'SELECT code FROM user WHERE code ORDER BY code DESC LIMIT 1');

?>