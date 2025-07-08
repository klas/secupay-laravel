<?php
namespace Tests\Api;

class FlagbitCest
{
    private $validApiKey = 'valid_test_key';
    private $masterApiKey = 'valid_master_key';

    public function _before(ApiTester $I)
    {
        $I->haveApplicationInstance();
    }

    public function getActiveFlagbitsWithoutAuthFails(ApiTester $I)
    {
        $I->sendGET('/api/v1/flagbits/active?trans_id=1');
        $I->seeResponseCodeIs(401);
        $I->seeResponseContainsJson(['error' => 'API key required']);
    }

    public function getActiveFlagbitsWithValidKeyWorks(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', $this->validApiKey);
        $I->sendGET('/api/v1/flagbits/active?trans_id=1');
        $I->dontSeeResponseCodeIs(401);
        $I->dontSeeResponseCodeIs(403);
    }

    public function setFlagbitRequiresMasterKey(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', $this->validApiKey);
        $I->sendPOST('/api/v1/flagbits/set', ['trans_id' => 1, 'flagbit_id' => 4]);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson(['error' => 'Master key required']);
    }

    public function setFlagbitWithMasterKeyWorks(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', $this->masterApiKey);
        $I->sendPOST('/api/v1/flagbits/set', ['trans_id' => 1, 'flagbit_id' => 4]);
        $I->dontSeeResponseCodeIs(401);
        $I->dontSeeResponseCodeIs(403);
    }
}
