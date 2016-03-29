<?php
ini_set('display_errors','on');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/* Api Routes */

/**
 * @api {get} /session-status Get Feedback session status
 * @apiVersion 4.0.0
 * @apiName GetSessionStatus
 * @apiGroup Student
 *
 *
 * @apiSuccess {String} status 0 means no sessions are running 1 means a session is running
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": "0"
 *     }
 *
 */
$app->get('/session-status', function (Request $request, Response $response) {
  $db = connect_db();
  $result = $db->query('SELECT `Data1` FROM `table_data` WHERE `ID`= "Startup"');
  $row =$result->fetch_array(MYSQLI_ASSOC);
  $data = array('status' => $row['Data1']);
  return $response->withJson($data, 200);

  $this->logger->addInfo('Feedback Session Status : '.$status['Data1']);
});

/**
 * @api {get} /session-class Get Feedback session class
 * @apiVersion 4.0.0
 * @apiName GetSessionClass
 * @apiGroup Student
 *
 * @apiSuccess {String} class-code Code of the class
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "class_code": "Class2A"
 *     }
 *
 * @apiError SessionNotRunning No feedback session is in progress.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "session is not running"
 *     }
 */
$app->get('/session-class', function (Request $request, Response $response) {
  $db = connect_db();
  $result = $db->query('SELECT `Data1`,`Data2` FROM `table_data` WHERE `ID`= "Startup"');
  $row =$result->fetch_array(MYSQLI_ASSOC);
  if($row['Data1'] == 0){
    $data = array('error' => 'session is not running');
    return $response->withJson($data, 404);
  }else if($row['Data1'] == 1){
    $data = array('class_code' => $row['Data2']);
    return $response->withJson($data, 200);

    $this->logger->addInfo('Feedback Session Class : '.$status['Data2']);
  }
});

/**
 * @api {get} /timetable/:class_code Get Timetable of a class
 * @apiVersion 4.0.0
 * @apiName GetTimetable
 * @apiGroup Student
 * @apiDescription This is API returns the timetabe.
 * The number of items depends on the number of subject a class has.
 *
 * @apiParam {String} class_code unique class_code.
 *
 * @apiSuccess {String} Data1 The value is of the format `employee_code-subject_code`.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "Data1": "E0006-CS51",
 *       "Data2": "E0064-CS54",
 *       "Data3": "E0008-CS55",
 *       "Data4": "E0067-CS56",
 *       "Datax": "Exxx-xxxx"
 *     }
 *
 * @apiError TimetableNotFound The class_id of the Class was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "TimetableNotFound"
 *     }
 */
?>