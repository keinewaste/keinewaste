<?php


class PingCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function tryExistingEndpoint(AcceptanceTester $I)
    {
        $I->sendGET('/ping');
        $I->seeResponseCodeIs(200);
    }


    public function tryNotExistingEndpoint(AcceptanceTester $I)
    {
        $I->sendGET('/pingasd');
        $I->seeResponseCodeIs(404);
    }

}
