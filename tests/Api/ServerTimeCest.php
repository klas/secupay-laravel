<?php
namespace Tests\Api;

class ServerTimeCest
{
    public function _before(ApiTester $I)
    {
        $I->haveApplicationInstance();
    }

    public function getServerTimeTest(ApiTester $I)
    {
        $I->sendGET('/api/v1/time');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([]);
        $I->seeResponseJsonMatchesJsonPath('$.server_time');
        $I->seeResponseJsonMatchesJsonPath('$.timestamp');
        $I->seeResponseJsonMatchesJsonPath('$.timezone');
    }
}
