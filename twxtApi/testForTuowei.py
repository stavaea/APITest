import time
from socket import *
import json
import urllib2

import unittest

class TestAPI(unittest.TestCase):
    def setUp(self):
        print "\n" + "*"*20 + "Test start" + "*"*20 + "\n"

    def tearDown(self):
        print "\n" + "*"*20 + "Test end" + "*"*20

    def test_chnl_add_rtmp(self):
        values = {
          "appid":10001,
          "apphash":"7baac873edcb07a3bab8defeb60a435a",
          "params":
              {"classId":"1005084",
              "pl":"40",
              "pn":"1",
              "userId":"45"}
        }

        url = "http://testpx.gn100.com/openapi/openapi/course/detail";

        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()

        #print ("post content=%s" % values)
        #print ("retcode=%s, body=%s" % (ret_code, html_body))


if __name__ == "__main__":
    suite = unittest.TestSuite()
    suite.addTest(TestAPI('test_chnl_add_rtmp'))
    unittest.TextTestRunner(verbosity=2).run(suite)