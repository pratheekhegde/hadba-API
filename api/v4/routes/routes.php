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
  //$this->logger->addNotice('Feedback Session Status : '.$row['Data1']);
  return $response->withJson($data, 200, JSON_PRETTY_PRINT);
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
    return $response->withJson($data, 404, JSON_PRETTY_PRINT);
  }else if($row['Data1'] == 1){
    $data = array('class_code' => $row['Data2']);
    //$this->logger->addNotice('Feedback Session Class : '.$row['Data2']);
    return $response->withJson($data, 200, JSON_PRETTY_PRINT);
  }
});

/**
 * @api {get} /timetable/:class_code Get Timetable of a class
 * @apiVersion 4.0.0
 * @apiName GetTimetable
 * @apiGroup Student
 * @apiDescription This is API returns the timetable of a class.
 * The number of items depends on the number of subject a class has.
 * First item is the requested `class_code`. Second is the `class_name` then follows the timetable.
 *
 * @apiParam {String} class_code unique class_code.
 *
 * @apiSuccess {String} class_code Code of the class of which the timetable was requested.
 * @apiSuccess {String} class_name Name of the class.
 * @apiSuccess {object[]} timetable List of subjects.
 * @apiSuccess {String} timetable.emp_code  Employee code of the faculty.
 * @apiSuccess {String} timetable.emp_name  Name of the faculty.
 * @apiSuccess {String} timetable.sub_code  Code of the Subject.
 * @apiSuccess {String} timetable.sub_name  Name of the Subject.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *      "class_code": "Class2B",
 *      "class_name": "2nd Year CSE B Section",
 *      "timetable": [
 *          {
 *            "emp_code": "E0046",
 *            "emp_name": "Bhagyalaxmi Navada",
 *            "sub_code": "MAT41",
 *            "sub_name": "Engineering Mathematics 4"
 *          },
 *          {
 *            "emp_code": "E0287",
 *            "emp_name": "Ramyashree",
 *            "sub_code": "CS42",
 *            "sub_name": "Graph Theory & Combinators"
 *          },
 *          {
 *            "emp_code": "E0148",
 *            "emp_name": "Praveen M Naik",
 *            "sub_code": "CS43",
 *            "sub_name": "Design And Analysis of Algorithms"
 *          }
 *      ]
 *    }
 *
 * @apiError TimetableNotFound The class_code of the Class was not found or the timetable is not in the Database.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "TimetableNotFound"
 *     }
 */
 $app->get('/timetable/{class_code}', function (Request $request, Response $response, $args) {
   //Class code is a parameter
   $class_code = $args['class_code'];

   $db = connect_db();

   //Get Class Name from class code
   $result = $db->query("SELECT `class_name` FROM `table_class` WHERE `class_code`= '".$class_code."'");
   $row = $result->fetch_array(MYSQLI_ASSOC);
   if($row['class_name']){
    $class_name = $row['class_name'];
    }else{
      $class_name = "Class code not defined";
    }

   //Get Timetable Mappings
   $result = $db->query("SELECT * FROM `table_data` WHERE `ID`= '".$class_code."'");
   $row =$result->fetch_array(MYSQLI_ASSOC);

   if($row){
     //Remove empty values (at the end there are empty key value pairs)
     $row = array_filter($row);

     //Remove first element because it is ID, we don't need it
     array_shift($row);

     foreach ($row as $key => $value) {
       //seperate class code and fac code
       $map=explode("-",$value);

       //Get Employee/Faculy Name
       $result = $db->query("SELECT * FROM `table_faculty_info` WHERE `empcode`= '".$map[0]."'");
       $row =$result->fetch_array(MYSQLI_ASSOC);

       //Get Subject Name
       $result = $db->query("SELECT * FROM `table_subjects` WHERE `subcode`= '".$map[1]."'");
       $row1 =$result->fetch_array(MYSQLI_ASSOC);

       //Prepare the array of objects
       $mapping[] = array("emp_code" => $map[0],
                          "emp_name" => $row['name'],
                          "sub_code" => $map[1],
                          "sub_name" => $row1['subname']
                        );
     }
     $data = array('class_code' => $class_code,
                    'class_name' =>$class_name,
                    'timetable' => $mapping);
     //$this->logger->addNotice('Timetable Requested Class : '.$class_code.' Succes');
     return $response->withJson($data, 200, JSON_PRETTY_PRINT);
   }else{
     $data = array('error' => 'TimetableNotFound');
     $this->logger->addError('Timetable Requested Class : '.$class_code.' Failed');
     return $response->withJson($data, 404, JSON_PRETTY_PRINT);
   }
 });

 /**
  * @api {post} /feedback/ Save Feedback of a student
  * @apiVersion 4.0.0
  * @apiName PostFeedback
  * @apiGroup Student
  * @apiDescription This is API saves the feedback of the student.
  * The payload will contain the marks of the questions.
  * It will also have the `emp_code`,`class_code`, `id` will be generated before saving,
  * `timestamp` will be inserted by the database.
  *
  * @apiParam {String} emp_code Employee code of the faculty
  * @apiParam {String} class_code unique class_code.
  * @apiParam {object} feedback Marks for each question.
  * @apiParamExample {json} Request-Example:
  *     {
  *       "emp_code": "E0299",
  *       "class_code": "Class1A",
  *       "feedback": {
  *         "Q1": 2,
  *         "Q2": 3,
  *         "Q3": 1,
  *         "Q4": 2
  *        }
  *     }
  *
  * @apiSuccess (201) {String} status Status code 201.
  * @apiSuccess (201) {String} message Short description.
  * @apiSuccess (201) {String} client_id  Unique fignerprint for each feedback.
  *
  * @apiSuccessExample Success-Response:
  *     HTTP/1.1 201 OK
  *     {
  *       "status": "201",
  *       "message": "feedback was saved",
  *       "client_id": "d90d9be3160703b58253dcda043bc0e7"
  *     }
  *
  * @apiError FeedbackNotSaved The feedback was already submitted once .
  *
  * @apiErrorExample {json} Error-Response:
  *     HTTP/1.1 200 OK
  *     {
  *       "status": "400",
  *       "messaage": "feedback was not saved",
  *       "description": "Duplicate entry 'd90d9be3160703b58253dcda043bc0e7' for key 'PRIMARY'",
  *       "client_id": "d90d9be3160703b58253dcda043bc0e7"
  *     }
  */
 $app->post('/feedback', function (Request $request, Response $response) {
    $parsedBody = $request->getParsedBody();

    //prepare the payload
    $ipAddress = $request->getAttribute('ip_address');
    $emp_code = strtolower($parsedBody['emp_code']);
    $class_code = $parsedBody['class_code'];
    $feedback = json_encode($parsedBody['feedback']);

    //unique id for each feedback record MD5( ip + emp_code + class_code)
    $id = md5($ipAddress.$emp_code.$class_code);

    $query = "INSERT INTO table_feedback SET id='$id', emp_code='$emp_code', class_code='$class_code', feedback='$feedback'";
    $db = connect_db();
    $result = $db->query($query);
    if($result){
      $data = array('status' => '201',
                    'messaage' => 'feedback was saved',
                    'client_id' => $id );
      return $response->withJson($data, 201, JSON_PRETTY_PRINT);
    }else{
      $data = array('status' => '400',
                    'messaage' => 'feedback was not saved',
                    'description' => $db->error,
                    'client_id' => $id );
      $this->logger->addError('Save Feedback Failed : '.$class_code.' - '.$emp_code.', Reason => '.$db->error.'');
     return $response->withJson($data, 200, JSON_PRETTY_PRINT);
    }
 });
?>