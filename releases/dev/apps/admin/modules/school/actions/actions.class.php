<?php

require_once dirname(__FILE__).'/../lib/schoolGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/schoolGeneratorHelper.class.php';

/**
 * school actions.
 *
 * @package    olas
 * @subpackage school
 * @author     David Ward <dward@wevad.com>
 * @version    SVN: $Id: actions.class.php 69 2010-07-22 14:40:32Z dward $
 */
class schoolActions extends autoSchoolActions
{
	public function executeDownloadRUI(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' RU '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.ru_question_number AS question_number
  FROM question q
 WHERE q.ru_question_number IS NOT NULL
 ORDER BY q.ru_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.ru_class_id AS class_id, s.ethnicity, s.gender, s.ru_complete AS complete_dt, s.ru_start AS start_dt, (SELECT a.created_at FROM student_answer a WHERE a.student_id = s.id AND a.assessment = 'ru' ORDER BY a.created_at DESC LIMIT 1) AS last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.ru_start IS NOT NULL
   AND s.ru_complete IS NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.ru_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.ru_start IS NOT NULL
   AND s.ru_complete IS NULL
   AND a.assessment = 'ru'
 ORDER BY s.student_id ASC, q.ru_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'assessment' => 'ru',
			'now' => $now,
			'lTitle' => $lTitle,
			'headers' => array(
				'Number', 'Text', 'Race', 'Gender', 'Date',
                'district code', 'schoolid', 'class', 'studentid',
                'firstname', 'lastname',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Incompletes.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
  }

	public function executeDownloadRU(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' RU '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.ru_question_number AS question_number
  FROM question q
 WHERE q.ru_question_number IS NOT NULL
 ORDER BY q.ru_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.ru_class_id AS class_id, s.ethnicity, s.gender, s.ru_complete AS complete_dt, s.ru_start AS start_dt, s.ru_complete as last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.ru_complete IS NOT NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.ru_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.ru_complete IS NOT NULL
   AND a.assessment = 'ru'
 ORDER BY s.student_id ASC, q.ru_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'assessment' => 'ru',
			'now' => $now,
			'lTitle' => $lTitle,
			'headers' => array(
				'Number', 'Text', 'Race', 'Gender', 'Date',
				'district code', 'schoolid', 'class', 'studentid',
                'firstname', 'lastname'
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Aggregated Results.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
	}

	public function executeDownloadMOI(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' MO '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.mo_question_number AS question_number
  FROM question q
 WHERE q.mo_question_number IS NOT NULL
 ORDER BY q.mo_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.mo_class_id AS class_id, s.lesson_count, s.mo_complete AS complete_dt, s.mo_start AS start_dt, (SELECT a.created_at FROM student_answer a WHERE a.student_id = s.id AND a.assessment = 'mo' ORDER BY a.created_at DESC LIMIT 1) AS last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.mo_start IS NOT NULL
   AND s.mo_complete IS NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.mo_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.mo_complete IS NULL
   AND a.assessment = 'mo'
 ORDER BY s.student_id ASC, q.mo_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'now' => $now,
			'assessment' => 'mo',
			'lTitle' => $lTitle,
			'headers' => array(
				'Number', 'Date', 'schoolid', 'Class',
                'studentid', 'firstname', 'lastname', 'Lessons',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Incompletes.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
  }

	public function executeDownloadMO(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' MO '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.mo_question_number AS question_number
  FROM question q
 WHERE q.mo_question_number IS NOT NULL
 ORDER BY q.mo_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.mo_class_id AS class_id, s.lesson_count, s.mo_complete AS complete_dt, s.mo_start AS start_dt, s.mo_complete as last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.mo_start IS NOT NULL
   AND s.mo_complete IS NOT NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.mo_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.mo_complete IS NOT NULL
   AND a.assessment = 'mo'
 ORDER BY s.student_id ASC, q.mo_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'now' => $now,
			'assessment' => 'mo',
			'lTitle' => $lTitle,
			'headers' => array(
				'Number', 'Date', 'schoolid', 'Class',
                'studentid', 'firstname', 'lastname', 'Lessons',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Aggregated Results.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
	}

	public function executeToggleRUEnabled(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();
		$this->school->ru_enabled = !$this->school->ru_enabled;
		$this->school->save();
		$this->getUser()->setFlash('notice', 'Revving Up has been '.($this->school->ru_enabled?'enabled':'disabled').' for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchDisableRU(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->ru_enabled = false;
			$record->save();
		}

		$this->getUser()->setFlash('notice', 'Revving Up has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executeBatchEnableRU(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->ru_enabled = true;
			$record->save();
		}

		$this->getUser()->setFlash('notice', 'Revving Up has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executeToggleMOEnabled(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();
		$this->school->mo_enabled = !$this->school->mo_enabled;
		$this->school->save();
		$this->getUser()->setFlash('notice', 'Moving On has been '.($this->school->mo_enabled?'enabled':'disabled').' for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchDisableMO(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->mo_enabled = false;
			$record->save();
		}

		$this->getUser()->setFlash('notice', 'Moving On has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executeBatchEnableMO(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->mo_enabled = true;
			$record->save();
		}

		$this->getUser()->setFlash('notice', 'Moving On has been disabled for the selected schools.');
		$this->redirect('@school');
	}


	public function executePurgeRUData(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id = ?)
   AND assessment = 'ru'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$qry = <<<xENDx
UPDATE student
   SET ru_complete = NULL, ru_start = NULL, ru_sent = NULL, ru_shrads = NULL, shrads_error = NULL
 WHERE school_id = ?
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$this->getUser()->setFlash('notice', 'Revving Up data has been purged for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executePurgeMOData(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id = ?)
   AND assessment = 'mo'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$qry = <<<xENDx
UPDATE student
   SET mo_complete = NULL, mo_start = NULL, mo_sent = NULL, mo_shrads = NULL, shrads_error = NULL
 WHERE school_id = ?
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$this->getUser()->setFlash('notice', 'Moving On data has been purged for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchPurgeRUData(sfWebRequest $request){
		$idList = $request->getParameter('ids');
		if (count($idList) == 0) {
			return;
		}

		$idQ = '?';
		$idC = count($idList);
		for ($i = 1; $i < $idC; $i++) {
			$idQ .= ',?';
		}

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id IN ($idQ))
   AND assessment = 'ru'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}

		$qry = <<<xENDx
UPDATE student
   SET ru_complete = NULL, ru_start = NULL, ru_sent = NULL, ru_shrads = NULL, shrads_error = NULL
 WHERE school_id IN ($idQ)
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}
/*
		$deleted = Doctrine_Query::create()
			->delete()
			->from('StudentAnswer a')
			->leftJoin('a.Student s')
			->leftJoin('s.School c')
			->whereIn('c.school_id', $request->getParameter('ids'))
			->andWhere('a.assessment = "ru"')
			->execute();
*/
		$this->getUser()->setFlash('notice', 'Revving Up data has been purged for the selected schools.');
		$this->redirect('@school');
	}

	public function executeBatchPurgeMOData(sfWebRequest $request){
		$idList = $request->getParameter('ids');
		if (count($idList) == 0) {
			return;
		}

		$idQ = '?';
		$idC = count($idList);
		for ($i = 1; $i < $idC; $i++) {
			$idQ .= ',?';
		}

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id IN ($idQ))
   AND assessment = 'mo'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}

		$qry = <<<xENDx
UPDATE student
   SET mo_complete = NULL, mo_start = NULL, mo_sent = NULL, mo_shrads = NULL, shrads_error = NULL
 WHERE school_id IN ($idQ)
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}

		$this->getUser()->setFlash('notice', 'Moving On data has been purged for the selected schools.');
		$this->redirect('@school');
	}

	protected function createReport($options){
		set_time_limit(0);
		require(sfConfig::get('sf_lib_dir').'/vendor/phpexcel/Classes/PHPExcel.php');
// options [
//   school = school object
//   now = time of report
//   lTitle = title of report
//   headers = array of header titles (before questions)
//   qQry = Question Query
//   sQry = Student Query (including those for the headers)
//   aQry = Answer Query
//   filename = filename of report
// ]
		$now = $options['now'];
		$lTitle = $options['lTitle'];


		// Setup DB connection
		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();


		// Setup PHPExcel caching of data
		//$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array('memoryCacheSize' => '8MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

		// Create Excel file
		$ss = new PHPExcel();
		$ss->getProperties()
			->setCreator('Online Assessment System')
			->setLastModifiedBy('Online Assessment System')
			->setTitle($lTitle)
			->setSubject($lTitle)
			->setDescription($lTitle)
		;

		$ss->getDefaultStyle()->getFont()->setName('Arial');
		$ss->getDefaultStyle()->getFont()->setSize(10);

		$ss->setActiveSheetIndex(0);

		$ss->getActiveSheet()->setTitle($options['school']->getName());

		// Setup header for file
		$headers = $options['headers'];
		$headerCount = count($headers);
		$headercol = 0;
		foreach ($headers as $header){
			$ss->getActiveSheet()->setCellValueByColumnAndRow($headercol++, 1, $header);
		}


		// Get Question Information
		$stmt = $dbh->prepare($options['qQry']);
		if ($stmt->execute()) {
			$qCol = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$qCol[$row['id']] = $headercol++;
				$ss->getActiveSheet()->setCellValueByColumnAndRow($qCol[$row['id']], 1, 'q'.$row['question_number']);
			}
		}
		$stmt = null;


		if ($options['assessment'] == 'ru') {
			// School name column needs to be wider
			$ss->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		}

		$saveTimeZone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$stmt = $dbh->prepare($options['sQry']);
		if ($stmt->execute(array(':school_id'=>$options['school']->getId()))) {
			$cnt = 2;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$sRow[$row['sid']] = $cnt++;

				$col = 0;

				$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $sRow[$row['sid']]-1); // Row number - RU, MO

                if ($options['assessment'] == 'ru' || $options['assessment'] == 'elem_ru' || $options['assessment'] == 'elem_mo') {
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $options['school']->getName()); // School name - RU, Elem RU
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['ethnicity']); // Ethnicity - RU, Elem RU
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['gender']); // Gender - RU, Elem RU
				}

                if ($options['assessment'] == 'elem_ru' || $options['assessment'] == 'elem_mo') {
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['age']); // Age - Elem RU
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['grade']); // Grade - Elem RU
                    $ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['teacher']); // Teacher - Elem RU
				}

				// Date has special formatting
				$dt = (int) PHPExcel_Shared_Date::PHPToExcel($row['complete_dt']?strtotime($row['complete_dt']):($row['last_dt']?strtotime($row['last_dt']):$now));
                $ss->getActiveSheet()->setCellValueByColumnAndRow($col, $sRow[$row['sid']], $dt); // Date -- RU, MO, Elem RU, Elem MO
                    $ss->getActiveSheet()->getStyleByColumnAndRow($col++, $sRow[$row['sid']])->getNumberFormat()->setFormatCode('m/d/y');

                if ($options['assessment'] == 'ru' || $options['assessment'] == 'elem_ru' || $options['assessment'] == 'elem_mo') {
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $options['school']->getDistrictId()); // District ID - RU, Elem RU
				}
				$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $options['school']->getSchoolId()); // School ID - RU, MO, Elem RU
				$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['class_id']); // Class ID - RU, MO, Elem RU

				// Student has special formatting
				$ss->getActiveSheet()->setCellValueByColumnAndRow($col, $sRow[$row['sid']], $row['student_id']); // Student ID - RU, MO, Elem RU
                    //$ss->getActiveSheet()->getCellByColumnAndRow($col++, $sRow[$row['sid']])->setValueExplicit($row['student_id'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $ss->getActiveSheet()->getStyleByColumnAndRow($col++, $sRow[$row['sid']])->getNumberFormat()->setFormatCode(str_repeat('0', strlen($row['student_id'])));

                // First and Last Name
                $ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['first_name']); // firstname - RU, MO, Elem RU, Elem MO
                $ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['last_name']); // lastname - RU, MO, Elem RU, Elem MO

				if ($options['assessment'] == 'mo') {
					$ss->getActiveSheet()->setCellValueByColumnAndRow($col++, $sRow[$row['sid']], $row['lesson_count']); // Lesson Count - MO
				}
			}
		}
		$stmt = null;
		date_default_timezone_set($saveTimeZone);


		$stmt = $dbh->prepare($options['aQry']);
		if ($stmt->execute(array(':school_id'=>$options['school']->getId()))) {
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$value = $row['value'];
				if ($value) {
					$ss->getActiveSheet()->setCellValueByColumnAndRow($qCol[$row['qid']], $sRow[$row['sid']], $value);
				}
			}
		}
		$stmt = null;


		$ss->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Number');
		$ss->setActiveSheetIndex(0);


		// Send the file
		$filename = $options['filename'];

		$this->setLayout(false);
		$response = $this->getResponse();
		$response->clearHttpHeaders();
		if (function_exists("apache_setenv")) {
			apache_setenv('no-gzip', 1);
		}
		ini_set('zlib.output_compression', 0);
		ini_set('implicit_flush', 1);

		$lifetime = 0;
                $expires = gmdate("D, d M Y H:i:s", time()+$lifetime)." GMT";
                $response->addCacheControlHttpHeader('public');
                $response->addCacheControlHttpHeader('max-age', $lifetime);
                $response->setHttpHeader('Pragma', null, false);
                $response->setHttpHeader('Expires', $expires, true);

		// Excel5
		$response->setContentType('application/vnd.ms-excel');

//$response->setHttpHeader('Content-Length', $contentLength, true);
		$response->setHttpHeader('Content-Disposition', "attachment; filename=\"{$filename}\"", true);
		$response->setHttpHeader('Content-Description', "{$filename}", true);
		$response->setHttpHeader('Connection', 'close', true);

		$response->sendHttpHeaders();

		$ssWriter = PHPExcel_IOFactory::createWriter($ss, 'Excel5');
		$ssWriter->save('php://output');

		$ss->disconnectWorksheets();
		unset($ss);

		return sfView::NONE;
	}





	public function executeDownloadElemRUI(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' Elem RU '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.elem_ru_question_number AS question_number
  FROM question q
 WHERE q.elem_ru_question_number IS NOT NULL
 ORDER BY q.elem_ru_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.elem_ru_age AS age, s.elem_ru_grade AS grade, s.elem_ru_class_id AS class_id, s.elem_ru_teacher AS teacher, s.elem_ru_ethnicity AS ethnicity, s.gender AS gender, s.elem_ru_complete AS complete_dt, s.elem_ru_start AS start_dt, (SELECT a.created_at FROM student_answer a WHERE a.student_id = s.id AND a.assessment = 'elem_ru' ORDER BY a.created_at DESC LIMIT 1) AS last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.elem_ru_start IS NOT NULL
   AND s.elem_ru_complete IS NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.elem_ru_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.elem_ru_start IS NOT NULL
   AND s.elem_ru_complete IS NULL
   AND a.assessment = 'elem_ru'
 ORDER BY s.student_id ASC, q.elem_ru_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'assessment' => 'elem_ru',
			'now' => $now,
			'lTitle' => $lTitle,
			'headers' => array(
                'Number', 'Text', 'Race', 'Gender',
                'age', 'grade', 'teacher',
                'Date',
				'district code', 'schoolid', 'class', 'studentid',
                'firstname', 'lastname',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Incompletes.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
  }

    public function executeDownloadElemRU(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' Elem RU '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.elem_ru_question_number AS question_number
  FROM question q
 WHERE q.elem_ru_question_number IS NOT NULL
 ORDER BY q.elem_ru_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.elem_ru_age AS age, s.elem_ru_grade AS grade, s.elem_ru_class_id AS class_id, s.elem_ru_teacher AS teacher, s.elem_ru_ethnicity AS ethnicity, s.gender AS gender, s.elem_ru_complete AS complete_dt, s.elem_ru_start AS start_dt, (SELECT a.created_at FROM student_answer a WHERE a.student_id = s.id AND a.assessment = 'elem_ru' ORDER BY a.created_at DESC LIMIT 1) AS last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.elem_ru_complete IS NOT NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.elem_ru_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.elem_ru_complete IS NOT NULL
   AND a.assessment = 'elem_ru'
 ORDER BY s.student_id ASC, q.elem_ru_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'assessment' => 'elem_ru',
			'now' => $now,
			'lTitle' => $lTitle,
			'headers' => array(
                'Number', 'Text', 'Race', 'Gender',
                'age', 'grade', 'teacher',
                'Date',
				'district code', 'schoolid', 'class', 'studentid',
                'firstname', 'lastname',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Aggregated Results.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
	}

	public function executeToggleElemRUEnabled(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();
		$this->school->elem_ru_enabled = !$this->school->elem_ru_enabled;
		$this->school->save();
		$this->getUser()->setFlash('notice', 'Elementary Revving Up has been '.($this->school->elem_ru_enabled?'enabled':'disabled').' for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchDisableElemRU(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->elem_ru_enabled = false;
			$record->save();
		}

        $this->getUser()->setFlash('notice', 'Elementary Revving Up has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executeBatchEnableElemRU(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->elem_ru_enabled = true;
			$record->save();
		}

		$this->getUser()->setFlash('notice', 'Elementary Revving Up has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executePurgeElemRUData(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id = ?)
   AND assessment = 'elem_ru'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$qry = <<<xENDx
UPDATE student
   SET elem_ru_complete = NULL, elem_ru_start = NULL, elem_ru_sent = NULL, elem_ru_shrads = NULL, shrads_error = NULL
 WHERE school_id = ?
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$this->getUser()->setFlash('notice', 'Elementary Revving Up data has been purged for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchPurgeElemRUData(sfWebRequest $request){
		$idList = $request->getParameter('ids');
		if (count($idList) == 0) {
			return;
		}

		$idQ = '?';
		$idC = count($idList);
		for ($i = 1; $i < $idC; $i++) {
			$idQ .= ',?';
		}

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id IN ($idQ))
   AND assessment = 'elem_ru'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}

		$qry = <<<xENDx
UPDATE student
   SET elem_ru_complete = NULL, elem_ru_start = NULL, elem_ru_sent = NULL, elem_ru_shrads = NULL, shrads_error = NULL
 WHERE school_id IN ($idQ)
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}
/*
		$deleted = Doctrine_Query::create()
			->delete()
			->from('StudentAnswer a')
			->leftJoin('a.Student s')
			->leftJoin('s.School c')
			->whereIn('c.school_id', $request->getParameter('ids'))
			->andWhere('a.assessment = "elem_ru"')
			->execute();
*/
		$this->getUser()->setFlash('notice', 'Elementary Revving Up data has been purged for the selected schools.');
		$this->redirect('@school');
	}





    public function executeDownloadElemMOI(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' Elem MO '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.elem_mo_question_number AS question_number
  FROM question q
 WHERE q.elem_mo_question_number IS NOT NULL
 ORDER BY q.elem_mo_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.elem_mo_age AS age, s.elem_mo_grade AS grade, s.elem_mo_class_id AS class_id, s.elem_mo_teacher AS teacher, s.elem_mo_ethnicity AS ethnicity, s.gender AS gender, s.elem_mo_complete AS complete_dt, s.elem_mo_start AS start_dt, (SELECT a.created_at FROM student_answer a WHERE a.student_id = s.id AND a.assessment = 'elem_mo' ORDER BY a.created_at DESC LIMIT 1) AS last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.elem_mo_start IS NOT NULL
   AND s.elem_mo_complete IS NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.elem_mo_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.elem_mo_start IS NOT NULL
   AND s.elem_mo_complete IS NULL
   AND a.assessment = 'elem_mo'
 ORDER BY s.student_id ASC, q.elem_mo_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'assessment' => 'elem_mo',
			'now' => $now,
			'lTitle' => $lTitle,
			'headers' => array(
                'Number', 'Text', 'Race', 'Gender',
                'age', 'grade', 'teacher',
                'Date',
				'district code', 'schoolid', 'class', 'studentid',
                'firstname', 'lastname',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Incompletes.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
  }

    public function executeDownloadElemMO(sfWebRequest $request){
		$school_id = $request->getParameter('id');
		$school = Doctrine::getTable('School')->findOneById($school_id);

		if (!$school) {
			// TODO: Error, no such school
		}

		$now = time();
        $month = date('F', $now);
        if (strlen($month) > 4) {
          $month = date('M', $now).'.';
        }
        $lTitle = $school->getName().' Elem MO '.$month.date(' j Y', $now);

		$qQry = <<<xENDx
SELECT q.id, q.elem_mo_question_number AS question_number
  FROM question q
 WHERE q.elem_mo_question_number IS NOT NULL
 ORDER BY q.elem_mo_question_number ASC
xENDx;
		$sQry = <<<xENDx
SELECT s.id AS sid, s.student_id, s.first_name, s.last_name, s.elem_mo_age AS age, s.elem_mo_grade AS grade, s.elem_mo_class_id AS class_id, s.elem_mo_teacher AS teacher, s.elem_mo_ethnicity AS ethnicity, s.gender AS gender, s.elem_mo_complete AS complete_dt, s.elem_mo_start AS start_dt, (SELECT a.created_at FROM student_answer a WHERE a.student_id = s.id AND a.assessment = 'elem_mo' ORDER BY a.created_at DESC LIMIT 1) AS last_dt
  FROM student s
 WHERE s.school_id = :school_id
   AND s.elem_mo_complete IS NOT NULL
 ORDER BY s.student_id ASC
xENDx;
		$aQry = <<<xENDx
SELECT s.id AS sid, s.student_id, q.id AS qid, q.elem_mo_question_number AS question_number, a.value
  FROM student_answer a
  LEFT JOIN student s ON s.id = a.student_id
  LEFT JOIN question q ON q.id = a.question_id
 WHERE s.school_id = :school_id
   AND s.elem_mo_complete IS NOT NULL
   AND a.assessment = 'elem_mo'
 ORDER BY s.student_id ASC, q.elem_mo_question_number ASC
xENDx;
		$options = array(
			'school' => $school,
			'assessment' => 'elem_mo',
			'now' => $now,
			'lTitle' => $lTitle,
			'headers' => array(
                'Number', 'Text', 'Race', 'Gender',
                'age', 'grade', 'teacher',
                'Date',
				'district code', 'schoolid', 'class', 'studentid',
                'firstname', 'lastname',
			),
			'qQry' => $qQry,
			'sQry' => $sQry,
			'aQry' => $aQry,
			'filename' => $lTitle.' Aggregated Results.xls',
		);

		$this->createReport($options);

		return sfView::NONE;
	}

	public function executeToggleElemMOEnabled(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();
		$this->school->elem_mo_enabled = !$this->school->elem_mo_enabled;
		$this->school->save();
        $this->getUser()->setFlash('notice', 'Elementary Moving On has been '.($this->school->elem_mo_enabled?'enabled':'disabled').' for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchDisableElemMO(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->elem_mo_enabled = false;
			$record->save();
		}

        $this->getUser()->setFlash('notice', 'Elementary Moving On has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executeBatchEnableElemMO(sfWebRequest $request){
		$ids = $request->getParameter('ids');

		$records = Doctrine_Query::create()
			->from('School')
			->whereIn('id', $ids)
			->execute();

		foreach ($records as $record) {
			$record->elem_mo_enabled = true;
			$record->save();
		}

        $this->getUser()->setFlash('notice', 'Elementary Moving On has been disabled for the selected schools.');
		$this->redirect('@school');
	}

	public function executePurgeElemMOData(sfWebRequest $request){
		$this->school = $this->getRoute()->getObject();

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id = ?)
   AND assessment = 'elem_mo'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

		$qry = <<<xENDx
UPDATE student
   SET elem_mo_complete = NULL, elem_mo_start = NULL, elem_mo_sent = NULL, elem_mo_shrads = NULL, shrads_error = NULL
 WHERE school_id = ?
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute(array($this->school->id))) {
		}

        $this->getUser()->setFlash('notice', 'Elementary Moving On data has been purged for '.$this->school->getName().'.');
		$this->redirect('@school');
	}

	public function executeBatchPurgeElemMOData(sfWebRequest $request){
		$idList = $request->getParameter('ids');
		if (count($idList) == 0) {
			return;
		}

		$idQ = '?';
		$idC = count($idList);
		for ($i = 1; $i < $idC; $i++) {
			$idQ .= ',?';
		}

		$conn = Doctrine_Manager::getInstance()->getConnection('doctrine');
		$dbh = $conn->getDbh();
		$qry = <<<xENDx
DELETE FROM student_answer
 WHERE student_id IN (SELECT id FROM student WHERE school_id IN ($idQ))
   AND assessment = 'elem_mo'
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}

		$qry = <<<xENDx
UPDATE student
   SET elem_mo_complete = NULL, elem_mo_start = NULL, elem_mo_sent = NULL, elem_mo_shrads = NULL, shrads_error = NULL
 WHERE school_id IN ($idQ)
xENDx;
		$stmt = $dbh->prepare($qry);

		if ($stmt->execute($idList)) {
		}
/*
		$deleted = Doctrine_Query::create()
			->delete()
			->from('StudentAnswer a')
			->leftJoin('a.Student s')
			->leftJoin('s.School c')
			->whereIn('c.school_id', $request->getParameter('ids'))
			->andWhere('a.assessment = "elem_mo"')
			->execute();
*/
        $this->getUser()->setFlash('notice', 'Elementary Moving On data has been purged for the selected schools.');
		$this->redirect('@school');
	}
}
