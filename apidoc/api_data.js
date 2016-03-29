define({ "api": [
  {
    "type": "get",
    "url": "/session-class",
    "title": "Get Feedback session class",
    "version": "4.0.0",
    "name": "GetSessionClass",
    "group": "Student",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "class-code",
            "description": "<p>Code of the class</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"class_code\": \"Class2A\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SessionNotRunning",
            "description": "<p>No feedback session is in progress.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"session is not running\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/v4/routes/routes.php",
    "groupTitle": "Student"
  },
  {
    "type": "get",
    "url": "/session-status",
    "title": "Get Feedback session status",
    "version": "4.0.0",
    "name": "GetSessionStatus",
    "group": "Student",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>0 means no sessions are running 1 means a session is running</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": \"0\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/v4/routes/routes.php",
    "groupTitle": "Student"
  },
  {
    "type": "get",
    "url": "/timetable/:class_code",
    "title": "Get Timetable of a class",
    "version": "4.0.0",
    "name": "GetTimetable",
    "group": "Student",
    "description": "<p>This is API returns the timetabe. The number of items depends on the number of subject a class has.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "class_code",
            "description": "<p>unique class_code.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Data1",
            "description": "<p>The value is of the format <code>employee_code-subject_code</code>.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"Data1\": \"E0006-CS51\",\n  \"Data2\": \"E0064-CS54\",\n  \"Data3\": \"E0008-CS55\",\n  \"Data4\": \"E0067-CS56\",\n  \"DataX\": \"Exxx-xxxx\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TimetableNotFound",
            "description": "<p>The class_id of the Class was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"TimetableNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/v4/routes/routes.php",
    "groupTitle": "Student"
  }
] });
