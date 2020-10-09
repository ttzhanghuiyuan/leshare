define({ "api": [
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/bookClass",
    "title": "5-约课",
    "version": "1.0.0",
    "group": "NEED",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "cs_id",
            "description": "<p>课表id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "class_date",
            "description": "<p>约课时间eg:2020-09-02</p>"
          }
        ]
      }
    },
    "description": "<p>注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份(本接口需要)</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 1,\n    \"msg\": \"成功\",\n    \"data\": \"\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentBookclass"
  },
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/freezeClass",
    "title": "6-冻结课程",
    "version": "1.0.0",
    "group": "NEED",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_date",
            "description": "<p>冻结开始eg:2020-09-02</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "end_date",
            "description": "<p>冻结结束eg:2020-09-31</p>"
          }
        ]
      }
    },
    "description": "<p>注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份(本接口需要)</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 1,\n    \"msg\": \"成功\",\n    \"data\": \"\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentFreezeclass"
  },
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/getClassLevel",
    "title": "2-获取课程等级",
    "version": "1.0.0",
    "group": "NEED",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n  \"code\": 1,\n  \"msg\": \"成功\",\n  \"data\": {\n    \"list\": [\n      {\n        \"id\": 1,\n        \"name\": \"轮滑初级\"\n      },\n      {\n        \"id\": 2,\n        \"name\": \"轮滑中级\"\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentGetclasslevel"
  },
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/getOpenId",
    "title": "7-获取openid",
    "version": "1.0.0",
    "group": "NEED",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>前端login时获取的code</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.session_key",
            "description": "<p>会话密钥</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.openid",
            "description": "<p>用户唯一标识</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"code\": 1,\n  \"msg\": \"成功\",\n  \"data\": {\n    \"session_key\": \"/Lvkv4tifgACOOfPSeksGw==\",\n    \"openid\": \"oOj735eFPwiNx9hRoIhgZDT12Mds\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n  \"code\": 0,\n  \"msg\": \"code been used, hints: [ req_id: UJjeEVDNRa-jd0LoA ]\",\n  \"data\": \"\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentGetopenid"
  },
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/getTodayClassInfo",
    "title": "3-获取今日课表",
    "version": "1.0.0",
    "group": "NEED",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "level_id",
            "description": "<p>课程等级</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "date",
            "description": "<p>选择日期</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "data.list.start_hour",
            "description": "<p>开始时</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "data.list.start_minute",
            "description": "<p>开始分</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "data.list.end_hour",
            "description": "<p>结束时</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "data.list.end_minute",
            "description": "<p>结束分</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "data.list.left_num",
            "description": "<p>剩余可预约课节数</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n  \"code\": 1,\n  \"msg\": \"成功\",\n  \"data\": {\n    \"list\": [\n      {\n        \"id\": 1,\n        \"study_num\": 10,\n        \"start_hour\": 10,\n        \"start_minute\": 10,\n        \"end_hour\": 11,\n        \"end_minute\": 30,\n        \"left_num\": 10\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentGettodayclassinfo"
  },
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/getUserInfo",
    "title": "4-获取用户剩余课时",
    "version": "1.0.0",
    "group": "NEED",
    "description": "<p>注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份(本接口需要)</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "data.left_num",
            "description": "<p>剩余课时</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"code\": 1,\n    \"msg\": \"成功\",\n    \"data\": {\n        \"left_num\": 16\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentGetuserinfo"
  },
  {
    "type": "POST",
    "url": "https://www.loshare.club/api.php/student/student/matchUser",
    "title": "1-用户首次登录验证绑定",
    "version": "1.0.0",
    "group": "NEED",
    "description": "<p>注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "open_id",
            "description": "<p>小程序open_id-非空</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "wx_nick",
            "description": "<p>微信昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "header_url",
            "description": "<p>头像链接</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>后台号码-非空</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pass",
            "description": "<p>后台密码-非空</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "code",
            "description": "<p>返回码</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "msg",
            "description": "<p>中文解释</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n  \"code\": 1,\n  \"msg\": \"验证成功!\",\n  \"data\": \"\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/student/controller/StudentController.php",
    "groupTitle": "NEED",
    "name": "PostHttpsWwwLoshareClubApiPhpStudentStudentMatchuser"
  }
] });
