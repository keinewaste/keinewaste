<?php


class UserCest
{

    const ACCESS_TOKEN = 'CAAYBQjWI6owBAI9V7ZBZArN1jufoZCn9YEpi04ImtmpVbHWJ2qZBkEwH7lnRzZBaU6gzFoBCTdmXbF1FqzqDAm5Yz5p3ZBkG25DM3K4aYa7FyXflZBSn5eDQR9BEejouH4AArJqMNUt74cFiEjxSWppQ1snOoZBMEe3ZCx3TXOxpTsHr7oJ0ZCte2GsjtofFD5w9KEC31WZAZCPf29H64LJVbUof';

    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }


    public function getWrongToken(AcceptanceTester $I)
    {
        $I->amBearerAuthenticated('wrong_token');
        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(403);
    }

    public function getUnauthorized(AcceptanceTester $I)
    {
        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(403);
    }

    public function getMySelf(AcceptanceTester $I)
    {
        $I->amBearerAuthenticated(static::ACCESS_TOKEN);
        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(200);
    }


    public function updateMySelf(AcceptanceTester $I)
    {
        $I->amBearerAuthenticated(static::ACCESS_TOKEN);
        $I->sendPUT(
            '/users/me',
            json_encode(
                [
                    'bio'     => 'testbio',
                    'address' => 'testaddress'
                ]
            )
        );
        $I->seeResponseCodeIs(201);

        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(["bio" => "testbio", 'address' => 'testaddress']);


        $I->sendPUT(
            '/users/me',
            json_encode(
                [
                    'bio'     => 'testbio2',
                    'address' => 'testaddress2'
                ]
            )
        );
        $I->seeResponseCodeIs(201);

        $I->sendGet(
            '/users/me'
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(["bio" => "testbio2", 'address' => 'testaddress2']);
    }
}
